<?php
/* ***********************************************************
// INFO
// ***********************************************************
page related functionality
*/

incCls("menus/tabs.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class PGE {
	public static $dir = false;    // selected pfs directory

	private static $top = false;   // dir with actual focus (selected from menu)
	private static $inf = array(); // current page props
	private static $typ = "inc";   // current page type
	private static $trg = "";      // redirection directory


public static function init() {
	PGE::$top = PGE::$dir = ENV::getPage();
}

// ***********************************************************
// setting focus
// ***********************************************************
public static function restore() {
	PGE::load(PGE::$top);
}

public static function isCurrent($dir) {
	return ($dir === PGE::$dir);
}

// ***********************************************************
// loading page props
// ***********************************************************
public static function load($dir) {
	ENV::set("curDir", $dir);
	PGE::$inf = array(); if (! is_dir($dir)) return;
	PGE::$dir = $dir;

	$ini = new ini($dir); // = $dir/page.ini
	PGE::$typ = $ini->getType();
	PGE::$inf = $ini->getValues();

	PGE::set("title", $ini->getHead());
}

public static function loadPFS($dir = NV) {
	$uid = PFS::find($dir);
	$inf = PFS::item($uid);

	foreach ($inf as $key => $val) {
		PGE::$inf["pfs.$key"] = $val;
	}
}

// ***********************************************************
// retrieving page props
// ***********************************************************
public static function set($key, $value) {
	PGE::$inf[$key] = $value;
}
public static function get($key, $default = false) {
	return VEC::get(PGE::$inf, $key, $default);
}

public static function dir() {
	switch (PGE::$typ) {
		case "red": $dir = PGE::get("props_red.trg"); break;
		default:    $dir = PGE::$dir;
	}
	if (FSO::isHidden($dir)) return false;
	return APP::dir($dir);;
}

public static function level() {
	$loc = PGE::$dir;
	$dir = STR::after($loc, TAB_HOME); if (! $dir) return false;
	return FSO::level($dir);
}
public static function props($sec = "") {
	return VEC::match(PGE::$inf, $sec);
}

public static function pic($dir = false) {
	if (! $dir) $dir = PGE::dir();

	$pic = FSO::files($dir, "pic.*"); $pic = key($pic);
	return APP::url($pic);
}

public static function page() {
	$kap = PFS::get(NV, "chnum");

	$ini = new ini("files/toc.ini");
	return $ini->get("pagenums.$kap", "-");
}

// ***********************************************************
// include files
// ***********************************************************
public static function incFile() {
	$act = PGE::type();

	if ($act == "roo") return "include.php";  // default mode
	if ($act == "inc") return "include.php";  // default mode
	if ($act == "cha") return "chapter.php";  // collection of chapters
	if ($act == "col") return "collect.php";  // collection of files in separate dirs

	if ($act == "mim") return "mimeview.php"; // show files
	if ($act == "dow") return "download.php"; // download
	if ($act == "gal") return "gallery.php";  // show files
	if ($act == "upl") return "upload.php";   // upload
	if ($act == "cam") return "livecam.php";  // camera
	if ($act == "tut") return "tutorial.php"; // tutorial
	if ($act == "url") return "links.php";    // list of external links

	if ($act == "dbt") return "dbtable.php";  // database table
	if ($act == "cal") return "calpage.php";  // calender page

	if ($act == "red") { // internal redirection
		$trg = PGE::dir();
		$act = PGE::type($trg);
	}
	return "invalid.php";
}

// ***********************************************************
// user permissions
// ***********************************************************
public static function hasXs($dir) {
	if (! FS_LOGIN) return "r";

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
// common ini related tasks
// ***********************************************************
public static function UID($fso = false) {
	if (! $fso) return PGE::get("props.uid");
	return PGE::prop($fso, "getUID");
}
public static function type($fso = false) {
	return PGE::prop($fso, "getType", "inc");
}
public static function title($fso = false) {
	if (! $fso) return PGE::get("title");
	return PGE::get($fso, "getHead");
}

// ***********************************************************
private static function prop($fso, $fnc, $prm = false) {
	if (! $fso) $fso = PGE::dir();
	$ini = new ini($fso);
	return $ini->$fnc($prm);
}

// ***********************************************************
// debug
// ***********************************************************
public static function dump() {
	DBG::tview(PGE::$inf, "PGE::\$inf");
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
