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
*/

ENV::init();
ENV::set("blockme", false);

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class ENV {

// ***********************************************************
// merge environment variables
// ***********************************************************
public static function init() {
	self::mergeArr($_GET);
	self::mergeArr($_POST);
	self::seal();
}

// ***********************************************************
// storing variables
// ***********************************************************
private static function mergeArr($arr) {
	foreach ($arr as $key => $val) {
		self::set($key, $val);
	}
}

// ***********************************************************
// handling variables of global interest
// ***********************************************************
public static function set($key, $value) {
	if (self::isAction($key)) return;

	switch ($key) { // hiding passwords
		case "crdp": $value = STR::maskPwd($value); break;
	}
	return SSV::set($key, $value);
}

public static function get($key, $default = "") {
	return SSV::get($key, $default);
}

public static function setIf($key, $value) {
	$val = SSV::get($key, NV); if ($val !== NV) return $val;
	return SSV::set($key, $value);
}

// ***********************************************************
public static function setPage($value) {
	if (defined("TAB_HOME")) return self::set("pge.".TAB_HOME, $value);
	self::setParm("pge", $value);
}
public static function getPage() {
	return self::get("pge.".TAB_HOME);
}

public static function getTopDir() {
	$idx = APP_IDX;
	$tab = self::get("tab_$idx");
	return self::get("tpc_$tab");
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
// finalizing constants
// ***********************************************************
public static function seal() {
	$mod = self::get("vmode", "view");

	switch ($mod) {
		case "csv": $dst = "csv"; break; // retrieve data only
		case "prn": $dst = "prn"; break; // printing and pdf
		default:    $dst = "screen";
	}
	CFG::set("EDITING",  $mod);
	CFG::set("CUR_DEST", $dst);
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

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
