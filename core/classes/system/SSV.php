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

SSV::init();

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class SSV {
	private static $dat = false; // address of app's session vars

	private static $min = 15;    // timeout min
	private static $max = 180;   // timeout max


public static function init() {
	if (! isset( $_SESSION[APP_NAME])) $_SESSION[APP_NAME] = array();
	SSV::$dat = &$_SESSION[APP_NAME];

	SSV::chkReset();
	SSV::chkTimeOut();
	SSV::setTimeOut();

	SSV::set("files", $_FILES, "prm");
	SSV::set("post",  $_POST,  "prm");
	SSV::set("get",   $_GET,   "prm");
}

public static function reset() {
	SSV::$dat = array(
		"env" => array(), "oid" => array(), "tmr" => array(),
		"pfs" => array(), "tan" => array(), "log" => array(),
		"prm" => array(), "dbg" => array()
	);
}
public static function clear($div) {
	SSV::$dat[$div] = array();
}

// ***********************************************************
// app vars
// ***********************************************************
public static function set($key, $value, $div = "env") {
	$key = SSV::norm($key);
	SSV::$dat[$div][$key] = $value;
	return $value;
}

public static function get($key, $default = false, $div = "env") {
	$key = SSV::norm($key);
	$arr = VEC::get(SSV::$dat, $div); if (! $arr) return $default;
	return VEC::get($arr, $key, $default);
}

public static function getValues($div = "env") {
	return SSV::$dat[$div];
}

// ***********************************************************
public static function myFiles() {
	return array_keys($_SESSION);
}

public static function drop($key, $div = "env") {
	unset(SSV::$dat[$div][$key]);
}

public static function wipe($div = "env") {
	SSV::$dat[$div] = array();
}

// ***********************************************************
// other methods
// ***********************************************************
public static function norm($key) {
	$clr = str_split(".,: ");
	$key = str_replace($clr, "_", $key);
	return $key;
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private static function chkReset() {
	if (! isset($_GET["reset"])) return;
	SSV::reset(); unset($_GET["reset"]);
}

private static function chkTimeOut() { // drop all stored vars ?
	$vgl = SSV::get("timeout"); if (! $vgl) return;
	$now = time(); if ($vgl > $now) return;

	$_GET["dmode"] = "timeout";
	SSV::reset();
}

// ***********************************************************
private static function setTimeOut() {
	SSV::set("timeout", SSV::getTimeOut());
}
private static function getTimeOut() {
	$max = 30; if (defined("TIMEOUT"))
	$max = intval(TIMEOUT);

	if ($max < SSV::$min) $max = SSV::$min;
	if ($max < SSV::$max) $max = SSV::$max;

	return time() + ($max * 60);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
