<?php
/* ***********************************************************
// INFO
// ***********************************************************
picks up all infos available on pages in a website
i.e. tree from fs and ini file information

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("menues/PFS.php");

PFS::readTree();

$arr = PFS::getMenu();
$dat = PFS::getData($index);
$tit = PFS::getTitle();
$val = PFS::getCur("props.xxx", $default);
*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class PFS extends objects {
	static private $dat = array(); // menu items & props
	static private $uid = array(); // menu id list
	static private $idx = array(); // menu index list

	static private $dir = ""; // current topic
	static private $fil = ""; // name of static menu file
	static private $cnt = 1;


public static function init($dir = TOP_PATH) {
	self::$dat = self::$uid = self::$idx = array();

	self::$dir = self::norm($dir);
	self::$fil = self::getMFile($dir);
	self::$cnt = 1;

	self::readTree($dir);
	self::setLoc();
}

private static function norm($dir) {
	return STR::replace($dir, "/", DIR_SEP);
}

// ***********************************************************
// using static fs image
// ***********************************************************
public static function toggle() {
	if (is_file(self::$fil)) return FSO::kill(self::$fil);
	self::export();
}

private static function getMFile($dir) {
	$lng = CUR_LANG;
	$fil = FSO::join($dir, "$lng.pfs.stat");
	return $fil;
}

public static function isStatic($dir = TOP_PATH) {
	$fil = self::getMFile($dir);
	return is_file($fil);
}

private static function export() {
	$dat = var_export(self::$dat, true);
	$uid = var_export(self::$uid, true);
	$idx = var_export(self::$idx, true);

	APP::write(self::$fil, "<?php\nself::\$dat = $dat;\nself::\$uid = $uid;\nself::\$idx = $idx;\n?>");
}

private static function import() {
	if (  EDITING != "view")   return false;
	if (! is_file(self::$fil)) return false;
	include_once(self::$fil);
	return count(self::$dat);
}

// ***********************************************************
// reading fs tree - ini files
// ***********************************************************
public static function readTree($dir = NV) {
	if (self::import()) return;

	if ($dir == NV) $dir = self::$dir;
	$dir = APP::dir($dir); if (! $dir) return;
	$vis = (EDITING == "view");

	$nxt = self::readProps($dir);    if (! $nxt) return;
	$arr = FSO::folders($dir, $vis); if (! $arr) return;

    foreach ($arr as $dir => $nam) {
        self::readTree($dir, $vis);
    }
#	self::dump();
}

// ***********************************************************
// retrieving data
// ***********************************************************
public static function getData($index = false) {
	if ($index == "dat") return self::$dat;

	if ($index !== false) {
		$idx = self::getIndex($index); if (! $idx) return array();
		return self::$dat[$idx];
	}
	return array(
		"dat" => self::$dat,
		"uid" => self::$uid,
		"idx" => self::$idx
	);
}

public static function getTree($index) {
	$dir = self::getPath($index);
	$arr = self::$dat; $out = array();

	foreach ($arr as $key => $inf) {
		$chk = $inf["fpath"]; if (! STR::begins($chk, $dir)) continue;
		$out[$key] = $inf;
	}
	return $out;
}

// ***********************************************************
public static function setLoc($index = NV) {
	$loc = self::getIndex($index);
	$loc = self::chkLoc($loc);
	ENV::set("loc", $loc);
	ENV::set("pge.".TOP_PATH, $loc);
}
public static function getLoc($pge = NV) {
	if ($pge == NV) return ENV::get("loc");

	$loc = self::getIndex($pge);
	return $loc;
}
private static function chkLoc($dir) {
	if (APP::dir($dir)) return $dir;
	$dir = ENV::get("loc");

	while ($dir = dirname($dir)) {
		if ($dir < TAB_PATH) break; // no access outside tab path
		if (is_dir($dir)) return trim($dir, DIR_SEP);
	}
	return TOP_PATH;
}

// ***********************************************************
public static function getRoot() {
	return self::getPath(self::$dir);
}
public static function getPath($index = NV) {
	return self::getProp($index, "fpath");
}
public static function getLink($index = NV) {
	$out = self::getProp($index, "props.uid"); if ($out) return $out;
	return self::getPath($index);
}

// ***********************************************************
public static function getType($index = NV) {
	$out = self::getProp($index, "props.typ", "inc");
	return STR::left($out);
}
public static function getTitle($index = NV) {
	return self::getProp($index, "title", $index);
}
public static function getHead($index = NV) {
	$lng = CUR_LANG;
	$out = self::getProp($index, "$lng.head", $index);
	$cnt = substr_count($out, DIR_SEP); if (! $cnt) return $out;
	return self::getTitle($index);
}
public static function getLevel($idx) {
	$idx = STR::after($idx, self::$dir);
	$out = substr_count($idx, DIR_SEP) + 1;
	return $out;
}
private static function getStatic() {
	return sprintf("p%05d.htm", self::$cnt++);
}

// ***********************************************************
public static function getIndex($index) { // dir or uid expected !
	$key = $index;
	if ($key == NV) $key = ENV::getPage();
	if (! $key) $key = 0;

	if (isset(self::$dat[$key])) return $key;
	if (isset(self::$uid[$key])) return self::$uid[$key];
	if (isset(self::$idx[$key])) return self::$idx[$key];

	return false;
}

private static function index($dir) {
	if (! $dir) return self::$dir;
	$out = FSO::clearRoot($dir);
	$out = trim($out, DIR_SEP);
	return $out;
}

// ***********************************************************
// menu node info
// ***********************************************************
public static function mnuInfo($index) {
	if (! is_numeric($index)) {
		$chk = array_flip(self::$idx);
		$index = $chk[$index];
	}
	$idx = VEC::get(self::$idx, $index); if (! $idx) return array();
	$lev = self::getLevel($idx);
	$typ = self::getType($idx);

	$out = array(
		"title" => self::getTitle($idx),
		"head"  => self::getHead($idx),
		"uid"   => self::getProp($idx, "uid"),
		"fpath" => self::getPath($idx),
		"plink" => self::getLink($idx),
		"level" => $lev,
		"dtype" => $typ,
		"mtype" => self::mnuType($idx, $lev, $typ),
		"sname" => self::getProp($idx, "sname"),
		"grey"  => self::refType($idx)
	);
	return $out;
}

// ***********************************************************
private static function mnuType($idx, $lev, $typ) {
	if (EDITING == "view") {
		if ($typ == "col")    return "file";
	}
	if (  $lev < 2)           return "root";
	if (! APP::folders($idx)) return "file";
    if (  APP::find($idx))    return "both";
    return "menu";
}

// ***********************************************************
// handling properties
// ***********************************************************
private static function readProps($dir) { // single page info
	$dir = APP::dir($dir); if (! is_dir($dir)) return;
	$idx = self::index($dir);

	$ini = new ini($dir);
	$inf = $ini->getValues();
	$tit = $ini->getTitle();
	$uid = $ini->getUID();
	$typ = STR::left($ini->get("props.typ"));

	self::setPropVal($idx, "title", $tit);
	self::setPropVal($idx, "uid",   $uid);
	self::setPropVal($idx, "index", self::$cnt);
	self::setPropVal($idx, "level", self::getLevel($idx));
	self::setPropVal($idx, "sname", self::getStatic()); // for static output
	self::setPropVal($idx, "fpath", $idx);

	foreach ($inf as $key => $val) {
		self::setPropVal($idx, $key, $val);
	}
	self::$idx[] = $idx;
	self::$uid[$uid] = $idx;

	return self::hasFolders($typ);
}

private static function hasFolders($typ) {
	$chk = ( !STR::contains(".col.sur.", $typ));

	if (EDITING == "medit") {
		$btn = ENV::get("btn.menu"); if ($btn != "S") return true;
		return $chk;
	}
	if (EDITING == "view") return $chk;
	return true;
}


// ***********************************************************
public static function setProp($index, $key, $value) {
	$idx = self::getIndex($index); if (! $idx) return;
	self::setPropVal($idx, $key, $value);
}
private static function setPropVal($idx, $key, $value) {
	self::$dat[$idx][$key] = $value;
}

// ***********************************************************
public static function getCur($key, $default = false) {
	return self::getProp(NV, $key, $default);
}
private static function getProp($index, $key, $default = false) {
	$idx = self::getIndex($index); if (! $idx) return;
	$arr = VEC::get(self::$dat, $idx); if (! $arr) return $default;
	return VEC::get($arr, $key, $default);
}

// ***********************************************************
public static function count() {
	return count(self::$dat);
}

private static function refType($idx) {
	if (EDITING  !=  "view") return "active";
	if (FSO::isHidden($idx)) return "inactive";
	return "active";
}

// ***********************************************************
// directory listings
// ***********************************************************
public static function getMenu() {
	$out = array(); $cnt = 0;

	foreach (self::$dat as $any) {
		$out[$cnt] = self::mnuInfo($cnt++);
	}
	return $out;
}

// ***********************************************************
// check user permissions
// ***********************************************************
public static function hasXs($index = NV) {
	if (! FS_LOGIN) return "r"; $dir = self::getPath($index);

	$ini = new code();
	$xxx = $ini->readPath($dir, "perms.ini"); // inherit settings
	$arr = $ini->getValues("perms"); if (! $arr) return "r";

	$prm = VEC::get($arr, "*", "x");
	$prm = VEC::get($arr, CUR_USER, $prm);

    if (STR::contains($prm, "w")) return "w";
    if (STR::contains($prm, "r")) return "r";
    return false;
}

// ***********************************************************
// debugging
// ***********************************************************
public static function dump() { // collects all defined props from all ini files
	$out = array();

	foreach (self::$dat as $arr) {
		foreach ($arr as $key => $val) {
			if (! $key) continue;
			if (STR::contains($key, "dic.")) continue;
			$out[$key] = $val;
		}
	}
	ksort($out);
	DBG::vector($out);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
