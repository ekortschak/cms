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
$inf = PFS::mnuInfo($index);
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


public static function init($dir = TAB_HOME) {
	self::$dat = self::$uid = self::$idx = array();

	self::$dir = $dir;
	self::$fil = FSO::join("static", $dir, "pfs.stat");
	self::$cnt = 1;

	if (! self::getLast()) {
		self::readTree($dir);

		SSV::set("data", self::getData(), "pfs");
		SSV::set("topic", TAB_PATH, "pfs");
		SSV::set("reload", 0, "pfs");
	}
	self::setLoc();
}

// ***********************************************************
// reading fs tree - ini files
// ***********************************************************
public static function readTree($dir = NV) {
	if (self::import()) return;
	if ($dir == NV) $dir = self::$dir;

	$dir = APP::dir($dir); if (! $dir) return;
	$arr = FSO::folders($dir, ! IS_LOCAL);
	$nxt = self::readProps($dir); if (! $nxt) return;

    foreach ($arr as $dir => $nam) {
        self::readTree($dir);
    }
#	self::dump();
}

// ***********************************************************
// retrieving data
// ***********************************************************
private static function getLast() {
	$chk = ENV::getParm("reset");              if (! $chk) return false;
	$chk = SSV::get("reload", false, "pfs");   if (  $chk) return false;
	$tpc = SSV::get("topic", TAB_PATH, "pfs"); if ($tpc != TAB_PATH) return false;
	$arr = SSV::get("data", array(), "pfs");   if (! $arr) return false;

	self::$dat = $arr["dat"];
	self::$uid = $arr["uid"];
	self::$idx = $arr["idx"];
	return true;
}

// ***********************************************************
public static function getData($index = false) {
	if ($index == "dat") return self::$dat;
	if ($index == "uid") return self::$uid;
	if ($index == "idx") return self::$idx; if ($index) return array();

	return array(
		"dat" => self::$dat,
		"uid" => self::$uid,
		"idx" => self::$idx
	);
}

// ***********************************************************
// handling location
// ***********************************************************
public static function getLoc($pge = NV) {
	if ($pge == NV) return ENV::get("loc");

	$loc = self::getIndex($pge);
	return $loc;
}

private static function setLoc($index = NV) {
	$loc = self::getIndex($index);
	$loc = self::chkLoc($loc);
	ENV::set("loc", $loc);
	ENV::set("pge.".TAB_HOME, $loc);
}

private static function chkLoc($dir) {
	if (APP::dir($dir)) return $dir;
	$dir = ENV::get("loc");

	while ($dir = dirname($dir)) {
		if ($dir < TAB_PATH) break; // no access outside tab path
		if (is_dir($dir)) return trim($dir, DIR_SEP);
	}
	return TAB_HOME;
}

// ***********************************************************
// retrieving info
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

private static function isCollection($typ) {
	if (EDITING != "view") return false;
	return (STR::contains(".col.", $typ)); // collections
}

// ***********************************************************
public static function getType($index = NV) {
	return self::getProp($index, "props.typ", "inc");
}
public static function getTitle($index = NV) {
	return self::getProp($index, "title", $index);
}
public static function getHead($index = NV) {
	return self::getProp($index, "head", $index);
}
public static function getLevel($idx) {
	$idx = STR::after($idx, self::$dir);
	$out = substr_count($idx, DIR_SEP) + 1;
	return $out;
}

// ***********************************************************
public static function getIndex($key) { // dir, uid or num index expected !
	if ($key === NV) $key = ENV::getPage();
	if ($key === false) return false;

	$out = VEC::get(self::$idx, $key); if ($out) return $out;
	$out = VEC::get(self::$uid, $key); if ($out) return $out;
	$out = VEC::get(self::$dat, $key); if ($out) return $key;
	return false;
}

// ***********************************************************
// reading & handling properties
// ***********************************************************
private static function readProps($dir) { // single page info
	$dir = APP::dir($dir); if (! is_dir($dir)) return false;
	$idx = self::norm($dir);

	$ini = new ini($dir);
	$inf = $ini->getValues();
	$tit = $ini->getTitle();
	$uid = $ini->getUID();
	$typ = STR::left($ini->get("props.typ"));

	$lev = self::getLevel($idx);
	$nxt = self::getMType($idx, $typ, $lev);

	self::setPropVal($idx, "title", $tit);
	self::setPropVal($idx, "head",  "");
	self::setPropVal($idx, "uid",   $uid);
	self::setPropVal($idx, "index", self::$cnt);
	self::setPropVal($idx, "level", $lev);
	self::setPropVal($idx, "mtype", $nxt);
	self::setPropVal($idx, "fpath", $idx);
	self::setPropVal($idx, "sname", self::getStatID()); // for static output

	foreach ($inf as $key => $val) {
		self::setPropVal($idx, $key, $val);
	}
	self::$idx[] = $idx;
	self::$uid[$uid] = $idx;

	return (! self::isCollection($typ));
}

private static function getMType($dir, $typ, $lev) {
	if (self::isCollection($typ)) return "file";
	if ($lev < 2) return "root";

	$fld = (bool) APP::folders($dir, ! IS_LOCAL);
	$fil = (bool) APP::find($dir);

	if ($fld && $fil) return "both";
	if ($fld) return "menu";
	return "file";
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
private static function getProp($index, $key, $default = false) {
	$idx = self::getIndex($index);     if (! $idx) return $default;
	$arr = VEC::get(self::$dat, $idx); if (! $arr) return $default;
	return VEC::get($arr, $key, $default);
}

// ***********************************************************
public static function count() {
	return count(self::$dat);
}

private static function norm($dir) {
	$out = APP::relPath($dir);
	$out = trim($out, DIR_SEP);
	return $out;
}

// ***********************************************************
// menu node info
// ***********************************************************
public static function getMenu() {
	$out = array(); $max = count(self::$uid);

	for ($i = 0; $i < $max; $i++) {
		$out[$i] = self::mnuInfo($i);
	}
	return $out;
}

// ***********************************************************
public static function mnuInfo($index) {
	$idx = self::getIndex($index); if (! $idx) return array();
	$lev = self::getLevel($idx);
	$typ = self::getType($idx);

	$out = array(
		"title" => self::getTitle($idx),
		"head"  => self::getHead($idx),
		"uid"   => self::getProp($idx, "uid"),
		"sname" => self::getProp($idx, "sname"),
		"fpath" => self::getPath($idx),
		"plink" => self::getLink($idx),
		"level" => $lev,
		"dtype" => $typ,
		"mtype" => self::mnuType($idx, $lev, $typ),
		"grey"  => self::refType($idx)
	);
	return $out;
}

// ***********************************************************
private static function mnuType($idx, $lev, $typ) {
	if (EDITING == "view") {
		if ($typ == "col") return "file";
	}
	return self::getProp($idx, "mtype", false);
}

private static function refType($idx) {
	if (EDITING  !=  "view") return "active";
	if (FSO::isHidden($idx)) return "inactive";
	return "active";
}

// ***********************************************************
// static menues
// ***********************************************************
public static function isStatic() {
	return is_file(self::$fil);
}

// ***********************************************************
public static function toggle() {
	if (self::isStatic()) return FSO::kill(self::$fil);
	self::export();
}

// ***********************************************************
private static function export() {
	$dat = var_export(self::$dat, true);
	$uid = var_export(self::$uid, true);
	$idx = var_export(self::$idx, true);

	APP::write(self::$fil, "<?php\nself::\$dat = $dat;\nself::\$uid = $uid;\nself::\$idx = $idx;\n?>");
}

private static function import() {
	if (  EDITING != "view") return false;
	if (! self::isStatic())  return false;
	include_once(self::$fil);

	return count(self::$dat);
}

// ***********************************************************
private static function getStatID() {
	return sprintf("p%05d.htm", self::$cnt++);
}

// ***********************************************************
// user permissions
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
} // END OF CLASS
// ***********************************************************
?>
