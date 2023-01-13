<?php
/* ***********************************************************
// INFO
// ***********************************************************
meant to simplify handling of session variables

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("input/SSV.php");

SSV::init();
SSV::set($key, $val, $div);
SSV::get($key, $default, $div);

*/

session_start();

SSV::init();

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class SSV {
	private static $ses = false; // address of session vars
	private static $vrs = false; // address of app's session vars
	private static $min = 15;
	private static $max = 180;


public static function init() {
	self::$ses = &$_SESSION; if (! isset(self::$ses[APP_IDX])) self::$ses[APP_IDX] = array();
	self::$vrs = &$_SESSION[APP_IDX];

	self::chkReset();
	self::chkTimeOut();
	self::setTimeOut();

	self::set("files", $_FILES, "prm");
	self::set("post",  $_POST,  "prm");
	self::set("get",   $_GET,   "prm");
}

public static function reset() {
	self::$vrs = array(
		"env" => array(), "oid" => array(),
		"pfs" => array(), "tan" => array(),
		"prm" => array(), "dbg" => array()
	);
}
public static function clear($div) {
	self::$vrs[$div] = array();
}

// ***********************************************************
// app vars
// ***********************************************************
public static function set($key, $value, $div = "env") {
	$key = self::norm($key);
	self::$vrs[$div][$key] = $value;
	return $value;
}

public static function get($key, $default = false, $div = "env") {
	$key = self::norm($key);
	$arr = VEC::get(self::$vrs, $div); if (! $arr) return $default;
	return VEC::get($arr, $key, $default);
}

// ***********************************************************
public static function myFiles() {
	return VEC::keys($_SESSION);
}

public static function getData($div = "env") {
	return VEC::get(self::$vrs, $div);
}

public static function drop($key, $div = "env") {
	unset(self::$vrs[$div][$key]);
}

public static function wipe($div = "env") {
	self::$vrs[$div] = array();
}

// ***********************************************************
// other methods
// ***********************************************************
public static function norm($key) {
	$key = STR::norm($key); $clr = str_split(".,: ");
	$key = str_replace($clr, "_", $key);
#	$key = strtolower($key);
	return $key;
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private static function chkReset() {
	if (! isset($_GET["reset"])) return;
	self::reset();
	$_GET["reset"] = 0;
}

private static function chkTimeOut() { // drop all stored vars ?
	$vgl = self::get("timeout"); if (! $vgl) return;
	$now = time(); if ($vgl > $now) return;

	$_GET["dmode"] = "timeout";
	self::reset();
}

// ***********************************************************
private static function setTimeOut() {
	self::set("timeout", self::getTimeOut());
}
private static function getTimeOut() {
	$max = 30; if (defined("TIMEOUT"))
	$max = intval(TIMEOUT);

	if ($max < self::$min) $max = self::$min;
	if ($max < self::$max) $max = self::$max;

	return time() + ($max * 60);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
