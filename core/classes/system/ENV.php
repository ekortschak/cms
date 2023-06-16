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
ENV::set("blockme", false);

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class ENV {

// ***********************************************************
// merge environment variables
// ***********************************************************
public static function init() {
	ENV::mergeArr($_GET);
	ENV::mergeArr($_POST);
}

private static function mergeArr($arr) {
	foreach ($arr as $key => $val) {
		if (ENV::isAction($key)) continue;
		ENV::set($key, $val);
	}
}

// ***********************************************************
// handling variables of global interest
// ***********************************************************
public static function set($key, $value) {
	switch ($key) { // hiding passwords
		case "crdp": $value = STR::maskPwd($value); break;
	}
	return SSV::set($key, $value, "env");
}

public static function get($key, $default = "") {
	return SSV::get($key, $default, "env");
}

public static function setIf($key, $value) {
	$val = SSV::get($key, NV, "env"); if ($val !== NV) return $val;
	return SSV::set($key, $value, "env");
}

// ***********************************************************
public static function setPage($value) {
	if (defined("TAB_HOME")) return ENV::set("pge.".TAB_HOME, $value);
	ENV::setParm("pge", $value);
}
public static function getPage() {
	return ENV::get("pge.".TAB_HOME);
}

public static function getTopDir() {
	$idx = APP_IDX;
	$tab = ENV::get("tab.$idx");
	return ENV::get("tpc.$tab");
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

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
