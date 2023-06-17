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
	private static $dat = array(); // menu items & props
	private static $uid = array(); // menu id list
	private static $idx = array(); // menu index list

	private static $dir = ""; // current topic
	private static $fil = ""; // name of static menu file
	private static $cnt = 1;


public static function init($dir = TAB_HOME) {
	PFS::$dir = $dir;
	PFS::$fil = FSO::join("static", $dir, "pfs.stat");
	PFS::$dat = PFS::$uid = PFS::$idx = array();
	PFS::$cnt = 1;

	if (! PFS::getLast()) {
		PFS::readTree($dir);

		SSV::set("data", PFS::getData(), "pfs");
		SSV::set("topic", TAB_PATH, "pfs");
		SSV::set("reload", 0, "pfs");
	}
	PFS::setLoc();
}

// ***********************************************************
// reading fs tree - ini files
// ***********************************************************
public static function readTree($dir = NV) {
	if (PFS::import()) return;
	if ($dir === NV) $dir = PFS::$dir;

	$dir = APP::dir($dir);
	$drs = FSO::dtree($dir, ! IS_LOCAL);
	$drs[$dir] = $dir;

	foreach ($drs as $dir => $nam) {
		PFS::readProps($dir);
	}
}

// ***********************************************************
// retrieving data
// ***********************************************************
private static function getLast() {
	$chk = ENV::getParm("reset");              if ($chk) return false;
	$chk = SSV::get("reload", false,   "pfs"); if ($chk) return false;
	$tpc = SSV::get("topic", TAB_PATH, "pfs"); if ($tpc != TAB_PATH) return false;
	$arr = SSV::get("data", array(),   "pfs"); if (! $arr) return false;

	PFS::$dat = $arr["dat"];
	PFS::$uid = $arr["uid"];
	PFS::$idx = $arr["idx"];
	return true;
}

// ***********************************************************
public static function getData($index = false) {
	if ($index == "dat") return PFS::$dat;
	if ($index == "uid") return PFS::$uid;
	if ($index == "idx") return PFS::$idx; if ($index) return array();

	return array(
		"dat" => PFS::$dat,
		"uid" => PFS::$uid,
		"idx" => PFS::$idx
	);
}

// ***********************************************************
// handling location
// ***********************************************************
private static function setLoc($key = NV) {
	switch (ENV::getParm("pfs.nav")) {
		case "prev": $key = PFS::getNext(-1); break;
		case "next": $key = PFS::getNext(+1); break;
	}
	$loc = PFS::getIndex($key);
	$loc = PFS::chkLoc($loc);

	ENV::setPage($loc);
	PGE::load($loc);
}

private static function chkLoc($dir) {
	if (APP::dir($dir)) return $dir;

	while ($dir = dirname($dir)) {
		if ($dir < TAB_PATH) break; // no access outside tab path
		if (is_dir($dir)) return FSO::trim($dir);
	}
	return TAB_HOME;
}

// ***********************************************************
// retrieving info
// ***********************************************************
public static function getRoot() {
	return PFS::getPath(PFS::$dir);
}
public static function getPath($index = NV) {
	return PFS::getProp($index, "fpath");
}
public static function getLink($index = NV) {
	$out = PFS::getProp($index, "props.uid"); if ($out) return $out;
	return PFS::getPath($index);
}

private static function isCollection($typ) {
	if (VMODE != "view") return false;
	return (STR::features("col", $typ)); // collections
}

// ***********************************************************
public static function getType($index = NV) {
	return PFS::getProp($index, "props.typ", "inc");
}
public static function getTitle($index = NV) {
	$lng = CUR_LANG;
	$out = PFS::getProp($index, CUR_LANG.".title", false); if ($out) return $out;
	return PFS::getProp($index, GEN_LANG.".title", ucfirst(basename($index)));
}
public static function getHead($index = NV) {
	return PFS::getProp($index, "head", $index);
}
public static function getLevel($idx) {
	$idx = STR::after($idx, PFS::$dir);
	return STR::count($idx, DIR_SEP) + 1;
}

// ***********************************************************
public static function getIndex($key) { // dir, uid or num index expected !
	if ($key === NV) $key = ENV::getPage();
	if ($key === false) return false;

	$out = VEC::get(PFS::$idx, $key); if ($out) return $out;
	$out = VEC::get(PFS::$uid, $key); if ($out) return $out;
	$out = VEC::get(PFS::$dat, $key); if ($out) return $key;
	return false;
}

private static function getNext($inc) {
	$key = ENV::getPage(); $chk = array_flip(PFS::$idx);
	$idx = VEC::get($chk, $key, 0);
	return CHK::range($idx += $inc, 0, count(PFS::$idx) - 1);
}

// ***********************************************************
// reading & handling properties
// ***********************************************************
private static function readProps($dir) { // single page info
	$dir = APP::dir($dir); if (! is_dir($dir)) return false;
	$idx = PFS::norm($dir);

	$ini = new ini($dir);
	$inf = $ini->getValues();
	$tit = $ini->getTitle();
	$uid = $ini->getUID();
	$typ = $ini->getType();

	$lev = PFS::getLevel($idx);
	$nxt = PFS::getMType($idx, $typ, $lev);

	PFS::setPropVal($idx, "title", $tit);
	PFS::setPropVal($idx, "head",  "");
	PFS::setPropVal($idx, "uid",   $uid);
	PFS::setPropVal($idx, "index", PFS::$cnt);
	PFS::setPropVal($idx, "level", $lev);
	PFS::setPropVal($idx, "mtype", $nxt);
	PFS::setPropVal($idx, "fpath", $idx);
	PFS::setPropVal($idx, "sname", PFS::getStatID()); // for static output

	foreach ($inf as $key => $val) {
		PFS::setPropVal($idx, $key, $val);
	}
	PFS::$idx[] = $idx;
	PFS::$uid[$uid] = $idx;

	return (! PFS::isCollection($typ));
}

private static function getMType($dir, $typ, $lev) {
	if (PFS::isCollection($typ)) return "file";

	$fld = (bool) APP::folders($dir, ! IS_LOCAL);
	$fil = (bool) APP::find($dir);

	if ($fld && $fil) return "both";
	if ($fld) return "menu";
	return "file";
}


// ***********************************************************
public static function setProp($index, $key, $value) {
	$idx = PFS::getIndex($index); if (! $idx) return;
	PFS::setPropVal($idx, $key, $value);
}
private static function setPropVal($idx, $key, $value) {
	PFS::$dat[$idx][$key] = $value;
}

// ***********************************************************
private static function getProp($index, $key, $default = false) {
	$idx = PFS::getIndex($index); if (! $idx) return $default;
	$arr = VEC::get(PFS::$dat, $idx); if (! $arr) return $default;
	return VEC::get($arr, $key, $default);
}

private static function getPropVal($idx, $key, $default) {
	if (! isset(PFS::$dat[$idx][$key])) return $default;
	return PFS::$dat[$idx][$key];
}

// ***********************************************************
public static function count() {
	return count(PFS::$dat);
}

private static function norm($dir) {
	$out = APP::relPath($dir);
	return FSO::trim($out);
}

// ***********************************************************
// menu node info
// ***********************************************************
public static function getMenu($depth = 99) {
	$out = array(); $max = count(PFS::$uid);

	for ($i = 0; $i < $max; $i++) {
		$arr = PFS::mnuInfo($i, $depth); if (! $arr) continue;
		$out[] = $arr;
	}
	return $out;
}

// ***********************************************************
public static function mnuInfo($index, $depth = 99) {
	$dep = CHK::range($depth, 2, 99);

	$idx = PFS::getIndex($index); if (! $idx)    return array();
	$lev = PFS::getLevel($idx); if ($lev > $dep) return array();
	$typ = PFS::getType($idx);

	$out = array(
		"uid"   => PFS::getProp($idx, "uid"),
		"title" => PFS::getTitle($idx),
		"head"  => PFS::getHead($idx),
		"sname" => PFS::getProp($idx, "sname"),
		"fpath" => PFS::getPath($idx),
		"plink" => PFS::getLink($idx),
		"level" => $lev,
		"dtype" => $typ,
		"mtype" => PFS::mnuType($idx, $lev, $typ),
		"state" => PFS::refType($idx),
	);
	return $out;
}

// ***********************************************************
private static function mnuType($idx, $lev, $typ) {
	if (VMODE == "view") {
		if ($typ == "col") return "file";
	}
	return PFS::getProp($idx, "mtype", false);
}

private static function refType($idx) {
	if (VMODE !=  "view") return "active";
	if (FSO::isHidden($idx)) return "inactive";
	return "active";
}

// ***********************************************************
// static menues
// ***********************************************************
public static function isStatic() {
	return is_file(PFS::$fil);
}

// ***********************************************************
public static function toggle() {
	if (PFS::isStatic()) return FSO::kill(PFS::$fil);
	PFS::export();
}

// ***********************************************************
private static function export() { // write menu info to stat file
	APP::write (PFS::$fil, "<?php");
	APP::append(PFS::$fil, "PFS::\$dat = ".var_export(PFS::$dat, true).";");
	APP::append(PFS::$fil, "PFS::\$uid = ".var_export(PFS::$uid, true).";");
	APP::append(PFS::$fil, "PFS::\$idx = ".var_export(PFS::$idx, true).";");
	APP::append(PFS::$fil, "?>");
}

private static function import() {
	if (  VMODE != "view")  return false;
	if (! PFS::isStatic()) return false;

	include_once PFS::$fil; // read menu info from stat file
	return count(PFS::$dat);
}

// ***********************************************************
private static function getStatID() {
	return sprintf("p%05d.htm", PFS::$cnt++);
}

// ***********************************************************
// user permissions
// ***********************************************************
public static function hasXs($index = NV) {
	if (! FS_LOGIN) return "r"; $dir = PFS::getPath($index);

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
