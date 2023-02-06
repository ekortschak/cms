<?php
/* ***********************************************************
// INFO
// ***********************************************************
page related functionality

*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class PGE {
	private static $sets = ""; // tabsets
	private static $tabs = ""; // tabs
	private static $tpcs = ""; // topics

	private static $tpc = "";  // current topic
	private static $pge = "";  // current page props

public static function init() {
	$idx = APP_IDX;
	$tab = self::getTab();
	$typ = self::getTabType($tab);
	$tpc = self::getTopic($tab, $typ);
	$pge = self::getPage($tpc);

	if ($typ != "sel") $tab = $tpc;

	CFG::set("TAB_HOME", $tpc);
	CFG::set("TAB_ROOT", APP::dir($tab.DIR_SEP));
	CFG::set("TAB_PATH", APP::dir($tpc.DIR_SEP));
	CFG::set("TAB_TYPE", $typ);
	CFG::set("CUR_TAB",  APP::relPath($tpc));

	ENV::set("tab.$idx", $tab);
	ENV::set("tpc.$tab", $tpc);
	ENV::set("pge.$tpc", $pge);
}

// ***********************************************************
// handling page props
// ***********************************************************
public static function load($dir) {
	CFG::set("CUR_PAGE", $dir);

	$ini = new ini($dir);
	self::$pge = $ini->getValues();
}

public static function get($key, $default = false) {
	return VEC::get(self::$pge, $key, $default);
}

// ***********************************************************
public static function getIncFile() {
	$typ = self::get("props.typ", "include");
	$typ = STR::left($typ);

	if ($typ == "roo") return "include.php";  // root
    if ($typ == "inc") return "include.php";  // default mode

	if ($typ == "mim") return "mimeview.php"; // show files
	if ($typ == "dow") return "download.php"; // download
    if ($typ == "gal") return "gallery.php";  // show files
    if ($typ == "upl") return "upload.php";   // upload
	if ($typ == "cam") return "livecam.php";  // camera
    if ($typ == "tut") return "tutorial.php"; // tutorial
	if ($typ == "red") return "redirect.php"; // redirection to another local directory
	if ($typ == "url") return "links.php";    // list of external links

	if ($typ == "col") { // collection of files in separate dirs
		if (ENV::get("vmode") == "xfer") return "collect.xsite.php";
		return "collect.php";
	}
	if ($typ == "dbt") return "dbtable.php";  // database table

	return false;
}

// ***********************************************************
// auxilliary methods for tabs
// ***********************************************************
private static function getTab() {
	$tpc = ENV::getParm("tpc"); if ($tpc) {
		return dirname($tpc);
	}
	$tab = ENV::getParm("tab");      if ($tab) return $tab;
	$tab = ENV::get("tab.".APP_IDX); if ($tab) return $tab;
	$set = basename(APP_IDX);

	$ini = new ini("config/tabsets.ini");
	$arr = $ini->getValues($set);
	$lst = array_flip($arr);

	$tab = VEC::get($lst, "default"); if ($tab) return $tab;
	return key($arr);
}

// ***********************************************************
private static function getTabType($tab) {
	$ini = new ini("$tab/tab.ini");
	$typ = $ini->getType("root");
	$std = $ini->get("props.std");

	if ($typ == "sel") self::$tpc = basename($std);
	return $typ;
}

// ***********************************************************
private static function getTopic($tab, $typ) {
	$tpc = ENV::getParm("tpc");  if ($tpc) return $tpc;
	$tpc = ENV::get("tpc.$tab"); if ($tpc) return $tpc;

	if ($typ != "sel") return $tab;
	return FSO::join($tab, self::$tpc);
}

// ***********************************************************
// auxilliary methods for pages
// ***********************************************************
private static function getPage($tab) {
	$pge = ENV::getParm("pge");  if ($pge) return $pge;
	$pge = ENV::get("pge.$tab"); if ($pge) return $pge;

	$ini = new ini("$tab/tab.ini");
	$pge = $ini->get("props.std");
	return $pge;
}

private static function langProp($prop) {
	$out = self::get(CUR_LANG.".$prop"); if ($out) return $out;
	$out = self::get("xx.$prop");        if ($out) return $out;
	$out = self::get(GEN_LANG.".$prop"); if ($out) return $out;
	$out = self::get($prop);             if ($out) return $out;
	return false;
}


// ***********************************************************
// common
// ***********************************************************
public static function getTitle($fso = CUR_PAGE) {
	$ini = new ini($fso);
	return $ini->getHead();
}

public static function getUID($fso) {
	$ini = new ini($fso);
	return $ini->getUID();
}

protected static function getValues($fso, $sec = "*") {
	$ini = new ini($fso);
	return $ini->getValues($sec);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
