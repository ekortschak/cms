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

	private static $pgs = 1;       // printed pages
	private static $skp = "";      // skip printing

	private static $toc = array(); // list of toc entries
	private static $nts = array(); // list of footnotes


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

public static function path($fso) {
	$fso = FSO::norm($fso);
	$out = APP::dir($fso); if ($out) return $out;
	return APP::file($fso);
}

// ***********************************************************
// loading page props
// ***********************************************************
public static function load($dir = NV) {
	if ($dir === NV) $dir = PFS::get(NV, "fpath");
	if (! is_dir($dir)) return;

	ENV::set("curDir", $dir);
	PGE::$dir = $dir;
	PGE::$inf = array();

 // retrieve ini-props
	$ini = new ini($dir); // = $dir/page.ini
	PGE::$typ = $ini->type();
	PGE::$inf = $ini->values();

	PGE::set("title", $ini->head());

 // retrieve PFS-props as well
	$inf = PFS::item($dir);

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
	return PGE::get("pfs.level");
}
public static function props($sec = "") {
	return VEC::match(PGE::$inf, $sec);
}

public static function pic($dir = false) {
	if (! $dir) $dir = PGE::dir();

	$pic = FSO::files($dir, "pic.*"); $pic = key($pic);
	$pic = APP::url($pic); if (! $pic) return;

	switch (VMODE) {
		case "xsite": HTW::thumbR($pic); break;
		default:      HTW::img($pic);
	}
}

// ***********************************************************
// include files
// ***********************************************************
public static function incFile() {
	$act = PGE::type();

	if ($act == "roo") return "include.php";  // default mode
	if ($act == "inc") return "include.php";  // default mode
	if ($act == "cha") return "chapter.php";  // collection of chapters

	if ($act == "col") {
		if (VMODE == "xsite") return "include.php";
		return "collect.php";  // collection of files in separate dirs
	}
	if ($act == "mim") return "mimeview.php"; // show files
	if ($act == "dow") return "download.php"; // download
	if ($act == "gal") return "gallery.php";  // show files
	if ($act == "upl") return "upload.php";   // upload
	if ($act == "cam") return "livecam.php";  // camera
	if ($act == "tut") return "tutorial.php"; // tutorial
	if ($act == "url") return "links.php";    // list of external links

	if ($act == "dbt") return "dbtable.php";  // database table
	if ($act == "cal") return "calpage.php";  // calender page
	if ($act == "red") return "redirect.php"; // internal redirection

	return "invalid.php";
}

// ***********************************************************
// user permissions
// ***********************************************************
public static function hasXs($dir) {
	if (! FS_LOGIN) return "r";

	$ini = new code();
	$xxx = $ini->readPath($dir, "perms.ini"); // inherit settings
	$arr = $ini->values("perms"); if (! $arr) return "r";

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
	return PGE::prop($fso, "UID");
}
public static function type($fso = false) {
	return PGE::prop($fso, "type", "inc");
}
public static function title($fso = false) {
	if ($fso) return PGE::prop($fso, "head");

	$prp = "title"; if (VMODE == "xsite")
	$prp = "pfs.chap";

	return PGE::get($prp);
}

// ***********************************************************
private static function prop($fso, $fnc, $prm = false) {
	if (! $fso) $fso = PGE::dir();
	$ini = new ini($fso);
	return $ini->$fnc($prm);
}

// ***********************************************************
// specials
// ***********************************************************
public static function pbreak() {
	if (VMODE != "xsite") return;
	if (PGE::$pgs++  < 2) return; // never on first page

	if (! PGE::get(CUR_LANG.".pbreak")) return;

	echo PAGE_BREAK;
}

public static function skip() {
	if (VMODE != "xsite") return false;

	$dir = PGE::get("pfs.vpath");

	if (PGE::get("props.noprint")) {
		PGE::$skp = $dir;
		return true;
	}
	if (PGE::$skp) { // skip subfolders as well
		if (STR::begins($dir, PGE::$skp)) return true;
	}
	PGE::$skp = "";
	return false;
}

private static function symbol($cap, $lev, $col) {
	if ($col == 2) {
		$out = end(explode(".", $cap)) + 96;
		return chr($out).")";
	}
	if ($lev <  1) return "";
	if ($lev == 6) return "&bull;";
	if ($lev == 7) return "&#9702;";
	if ($lev == 8) return "§";
	if ($lev == 9) return "+";
	if ($lev  > 9) return "-";

	return $cap;
}

// ***********************************************************
// handling toc
// ***********************************************************
public static function getToC() {
	return PGE::$toc;
}

public static function addToc($max = 2) {
	$lev = PGE::level(); if ($lev > $max) return;
	$key = PGE::get("pfs.chnum");
	$cap = PGE::get("pfs.chap");

	PGE::$toc[$key] = "$lev:$cap";
}

// ***********************************************************
// handling footnotes
// ***********************************************************
public static function getNotes() {
	return PGE::$nts;
}

public static function getIndex($key, $val) {
	$out = VEC::get(PGE::$nts, $key); if ($out) return $out;

	PGE::$nts[$key] = $val;
	return count(PGE::$nts);
}

// ***********************************************************
// transformations
// ***********************************************************
public static function convHeads($htm) {
	$htm = STR::replace($htm, "h1>", "hx>");
	$htm = STR::replace($htm, "h2>", "hx>");
	$htm = STR::replace($htm, "h3>", "hx>");
	$htm = STR::replace($htm, "h4>", "hx>");
	$htm = STR::replace($htm, "h5>", "hy>");
	$htm = STR::replace($htm, "h6>", "hz>");
	return $htm;
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
