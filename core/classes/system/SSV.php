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
	private static $dat = false; // address of app's session vars

	private static $min = 15;    // timeout min
	private static $max = 180;   // timeout max


public static function init() {
	if ( !  isset($_SESSION[APP_IDX])) $_SESSION[APP_IDX] = array();
	self::$dat = &$_SESSION[APP_IDX];

	self::chkReset();
	self::chkTimeOut();
	self::setTimeOut();

	self::set("files", $_FILES, "prm");
	self::set("post",  $_POST,  "prm");
	self::set("get",   $_GET,   "prm");
}

public static function reset() {
	self::$dat = array(
		"env" => array(), "oid" => array(), "tmr" => array(),
		"pfs" => array(), "tan" => array(), "log" => array(),
		"prm" => array(), "dbg" => array()
	);
}
public static function clear($div) {
	self::$dat[$div] = array();
}

// ***********************************************************
// app vars
// ***********************************************************
public static function set($key, $value, $div = "env") {
	$key = self::norm($key);
	self::$dat[$div][$key] = $value;
	return $value;
}

public static function get($key, $default = false, $div = "env") {
	$key = self::norm($key);
	if (! isset(self::$dat[$div][$key])) return $default;
	return      self::$dat[$div][$key];
}

public static function getValues($div = "env") {
	return self::$dat[$div];
}

// ***********************************************************
public static function myFiles() {
	return array_keys($_SESSION);
}

public static function drop($key, $div = "env") {
	unset(self::$dat[$div][$key]);
}

public static function wipe($div = "env") {
	self::$dat[$div] = array();
}

// ***********************************************************
// other methods
// ***********************************************************
public static function norm($key) {
#	$key = STR::norm($key);
	$clr = str_split(".,: ");
	$key = str_replace($clr, "_", $key);
#	$key = strtolower($key);
	return $key;
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private static function chkReset() {
	if (! isset($_GET["reset"])) return;
	self::reset(); unset($_GET["reset"]);
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
