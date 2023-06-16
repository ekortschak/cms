<?php
/* ***********************************************************
// INFO
// ***********************************************************
page related functionality
*/

incCls("menus/tabsets.php");
incCls("menus/topics.php");
incCls("menus/tabs.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class PGE {
	public static $dir = false;

	private static $sets = ""; // tabsets
	private static $tabs = ""; // tabs
	private static $tpcs = ""; // topics

	private static $tpc = "";  // current topic
	private static $pge = "";  // current page props


public static function init() {
	$idx = APP_IDX;
	$tab = PGE::getTab();
	$typ = PGE::getTabType($tab);
	$tpc = PGE::getTopic($tab, $typ);
	$pge = PGE::getPage($tpc);

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
	PGE::$dir = $dir;

	$ini = new ini($dir);
	PGE::$pge = $ini->getValues();
}

public static function get($key, $default = false) {
	return VEC::get(PGE::$pge, $key, $default);
}

// ***********************************************************
public static function incFile() {
	$act = PGE::get("props.typ", "include");

	$out = "$act.php";
	$ful = FSO::join(LOC_MOD, "body", $out);
	if (APP::file($ful)) return $out;

	switch (STR::left($act)) {
		case "roo": return "include.php";  // root
		case "inc": return "include.php";  // default mode

		case "mim": return "mimeview.php"; // show files
		case "dow": return "download.php"; // download
		case "gal": return "gallery.php";  // show files
		case "upl": return "upload.php";   // upload
		case "cam": return "livecam.php";  // camera
		case "tut": return "tutorial.php"; // tutorial
		case "red": return "redirect.php"; // redirection to another local directory
		case "url": return "links.php";    // list of external links

		case "dbt": return "dbtable.php";  // database table

		case "col": // collection of files in separate dirs
			if (VMODE != "xfer") return "collect.php";
			return "collect.xsite.php";
	}
	return "invalid.php";
}

public static function isCurrent($dir) {
	return ($dir == PGE::$dir);
}

public static function restore() {
 	ENV::setPage(PGE::$dir);
}

// ***********************************************************
// tab related methods
// ***********************************************************
public static function tabsets() {
#	return CFG::getValues("tabsets:".APP_CALL);

	$tbs = new tabsets();
	return $tbs->getTabs(APP_CALL);
}
public static function tabsetsVis() {
	$tbs = new tabsets();
	return $tbs->visTabs(APP_CALL);
}
public static function tabsetsVerify($set, $tab) {
	$tbs = new tabsets();
	return $tbs->verify($set, $tab);
}

public static function topics() {
	$tab = new topics();
	return $tab->getTopics();
}
public static function topicsVerify($tab, $std) {
	$arr = PGE::topics($tab);

	$std = FSO::join($tab, $std);
	$chk = VEC::get($arr, $std, NV); if ($chk === NV)
	$std = array_key_first($arr);
	return $std;
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

	$arr = CFG::getValues("tabsets:$set");
	$lst = VEC::flip($arr);
	$tab = VEC::get($lst, "default"); if ($tab) return $tab;
	return key($arr);
}

// ***********************************************************
private static function getTabType($tab) {
	$ini = new ini("$tab/tab.ini");
	$typ = $ini->getType("root");
	$std = $ini->get("props.std");

	if ($typ == "sel") PGE::$tpc = basename($std);
	return $typ;
}

// ***********************************************************
private static function getTopic($tab, $typ) {
	$tpc = ENV::getParm("tpc");  if ($tpc) return $tpc;
	$tpc = ENV::get("tpc.$tab"); if ($tpc) return $tpc;

	if ($typ != "sel") return $tab;
	return FSO::join($tab, PGE::$tpc);
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
	foreach (LNG::getRel() as $lng) {
		$out = PGE::get("$lng.$prop"); if ($out) return $out;
	}
	return PGE::get($prop, false);
}

// ***********************************************************
// common ini related tasks
// ***********************************************************
public static function getType($fso = false) {
	return PGE::getAny($fso, "getType", "inc");
}
public static function getTitle($fso = false) {
	return PGE::getAny($fso, "getHead");
}
public static function getUID($fso = false) {
	return PGE::getAny($fso, "getUID");
}
public static function getValues($fso = false, $sec = "*") {
	return PGE::getAny($fso, "getValues", $sec);
}

private static function getAny($fso, $fnc, $prm = false) {
	if (! $fso) $fso = PGE::$dir;
	$ini = new ini($fso);
	return $ini->$fnc($prm);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
