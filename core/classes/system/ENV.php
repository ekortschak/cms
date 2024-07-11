<?php
/* ***********************************************************
// INFO
// ***********************************************************
contains static functions for handling
* session variables
* post and get parameters
* constants

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("system/ENV.php");

$var = ENV::get($idx, $default); // session var
$var = ENV::getPost($idx, $default); // post var
$var = ENV::getParm($idx, $default); // get var
$var = ENV::find($idx, $default);
*/

ENV::init();
APP::block(false);

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class ENV {

public static function init() {
	ENV::mergeArr($_GET);
	ENV::mergeArr($_POST);

	ENV::setTab(APP_NAME.".".TAB_SET);
	ENV::setTpc(APP_NAME.".".TAB_SET);
	ENV::stdPage();
}

// ***********************************************************
// handling TABs
// ***********************************************************
private static function setTab($idx) {
	$tab = ENV::findTab($idx);

	CFG::set("TAB_TYPE", ENV::tabType($tab));
	CFG::set("TAB_ROOT", $tab);
	ENV::set("tab.$idx", $tab);
}
private static function findTab($idx) {
	$tab = ENV::getParm("tab");	 if ($tab) return $tab;
	$tab = ENV::get("tab.$idx"); if ($tab) return $tab;
	$arr = CFG::match("tabsets:".TAB_SET);

	foreach ($arr as $key => $val) {
		if (STR::contains($val, "default")) return $key;
	}
	return array_key_first($arr);
}

private static function tabType($tab) {
	$fil = FSO::join($tab, "tab.ini");

	$ini = new iniCfg($fil);
	$typ = $ini->get("props.typ", "root");
	$typ = STR::left($typ);

	if ($typ == "sel") return "sel";
	return "std";
}

// ***********************************************************
// handling Topics
// ***********************************************************
private static function setTpc($idx) {
	$tab = ENV::get("tab.$idx");
	$tpc = ENV::findTpc($idx, $tab);

	CFG::set("TAB_HOME", $tpc);
	ENV::set("tpc.$tab", $tpc);
}
private static function findTpc($idx, $tab) {
	if (TAB_TYPE != "sel") return $tab;

	$tpc = ENV::getParm("tpc");	 if ($tpc) return $tpc;
	$tpc = ENV::get("tpc.$tab"); if ($tpc) return $tpc;
	$fil = FSO::join($tab, "tab.ini");

	$ini = new iniCfg($fil);
	$tpc = $ini->get("props.std");

	$dir = FSO::join($tab, $tpc); if (! is_dir($dir))
	$dir = ENV::dir1st($tab);
	return $dir;
}

private static function dir1st($dir) {
	$arr = APP::dirs($dir);
	return array_key_first($arr);
}


// ***********************************************************
// handling Pages
// ***********************************************************
private static function stdPage() {
	$pge = ENV::findPage(TAB_HOME);
	$xxx = ENV::setPage($pge);
}
private static function findPage($tpc) {
	$pge = ENV::getParm("pge");  if ($pge) return $pge;
	$pge = ENV::get("pge.$tpc"); if ($pge) return $pge;
	$fil = FSO::join($tpc, "tab.ini");

	$ini = new iniCfg($fil);
	$pge = $ini->get("props.std");
	return $pge;
}

// ***********************************************************
public static function setPage($value) {
	if (! defined("TAB_HOME")) die("TAB_HOME not yet set");
	ENV::set("pge.".TAB_HOME, $value);
}
public static function getPage() {
	if (! defined("TAB_HOME")) die("TAB_HOME not yet set");
	return ENV::get("pge.".TAB_HOME);
}

// ***********************************************************
// handling variables of global interest
// ***********************************************************
public static function setIf($key, $value) {
	$val = SSV::get($key, NV, "env"); if ($val !== NV) return $val;
	return SSV::set($key, $value, "env");
}

public static function set($key, $value) {
	switch ($key) { // hiding passwords
		case "crdp": $value = STR::maskPwd($value); break;
	}
	return SSV::set($key, $value, "env");
}

public static function get($key, $default = "") {
	return SSV::get($key, $default, "env");
}

// ***********************************************************
public static function vmode() {
	if (OFFLINE) if (! IS_LOCAL) return "offline";

	if ($mod = ENV::getParm("dmode")) {
		ENV::set("vmode", "view");
		return $mod;
	}
	return ENV::get("vmode", "view");
}

// ***********************************************************
// handling form and request vars
// ***********************************************************
public static function getPost($key, $default = false) {
	$key = SSV::norm($key);
	$out = VEC::get($_POST,  $key, NV); if ($out !== NV) return $out;
	return VEC::get($_POST, "$key ", $default);
}

// ***********************************************************
public static function getParm($key, $default = false) {
	$key = SSV::norm($key);
	return VEC::get($_GET, $key, $default);
}

public static function setParm($key, $value) {
	$key = SSV::norm($key);
	$_GET[$key] = $value;
}

// ***********************************************************
public static function find($key, $default = false) {
	$out = ENV::getPost($key, NV); if ($out !== NV) return $out;
	$out = ENV::getParm($key, NV); if ($out !== NV) return $out;
	return ENV::get($key, $default);
}

// ***********************************************************
// auxilliary methdos
// ***********************************************************
private static function isAction($key) {
	if ($key == "tan") return true; // do not store tans
	if ($key == "act") return true; // do not store pressed buttons
	if (STR::ends($key, "_act")) return true;
	return false;
}

private static function mergeArr($arr) {
	foreach ($arr as $key => $val) {
		if (ENV::isAction($key)) continue;
		ENV::set($key, $val);
	}
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
