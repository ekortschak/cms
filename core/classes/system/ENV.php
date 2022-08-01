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
	CFG::set("APP_IDX", self::getIndex());

	self::chkReset();
#	self::clrTimeOut();

	self::mergeArr($_GET);
	self::mergeArr($_POST);
	self::seal();
}

// ***********************************************************
// storing variables
// ***********************************************************
private static function mergeArr($arr) {
	$oid = VEC::get($arr, "oid");

	if ($oid) {
		foreach ($arr as $key => $val) {
			self::oidSet($oid, $key, $val);
		}
		return;
	}
	foreach ($arr as $key => $val) {
		self::set($key, $val);
	}
}

private static function chkReset() {
	if (! self::getParm("reset")) return;
	session_unset();
}

// ***********************************************************
// handling object IDs
// ***********************************************************
private static function oidVals($oid = NV) { // all object related values
	if (  $oid == NV) $oid = self::getPost("oid", false);
	if (! $oid) return array();

	$arr = self::get("oid");
	return VEC::get($arr, $oid, array());
}
public static function oidValues($oid = NV, $pfx = "val_") { // object values by input
	$arr = self::oidVals($oid); $out = array();

	foreach ($arr as $key => $val) {
		if (! STR::begins($key, $pfx)) continue;
		$key = STR::after($key, $pfx);
		$out[$key] = $val;
	}
	return $out;
}

public static function oidGet($oid, $key, $default = false) {
	$key = self::norm($key);    if (! $key) return $default;
	$arr = self::oidVals($oid); if (! $arr) return $default;
	return VEC::get($arr, $key, $default);
}
public static function oidSet($oid, $key, $value) {
	$key = self::norm($key); if (! $key) return false;
	$_SESSION[APP_IDX]["oid"][$oid][$key] = $value;
	return $value;
}

public static function forget($oid = NV) {
	if ($oid == NV) $oid = self::getPost("oid", false); if (! $oid) return;
	unset($_SESSION[APP_IDX]["oid"][$oid]);
}

// ***********************************************************
// handling variables of global interest
// ***********************************************************
public static function set($key, $value) {
	return self::setSVar($key, $value);
}
public static function get($key, $default = "") {
	return self::getSVar($key, $default);
}

public static function setIf($key, $value) {
	$val = self::get($key, NV); if ($val != NV) return $val;
	return self::set($key, $value);
}

// ***********************************************************
public static function setPage($value) {
	self::set("pge.".TOP_PATH, $value);
}
public static function getPage() {
	return self::get("pge.".TOP_PATH);
}

public static function getTopDir() {
	$idx = APP_IDX;
	$tab = self::get("tab_$idx");
	return self::get("tpc_$tab");
}

private static function getIndex() {
	if (! STR::contains(APP_FILE, "x.edit")) return APP_FILE;
	return STR::replace(APP_FILE, "x.edit", "index");
}

// ***********************************************************
// handling session variables
// ***********************************************************
public static function getList() {
	return $_SESSION[APP_IDX];
}

private static function getSVar($key, $default = false) {
	$key = self::norm($key);
	$arr = VEC::get($_SESSION, APP_IDX); if (! $arr) return $default;
	return VEC::get($arr, $key, $default);
}

private static function setSVar($key, $val) {
	$key = self::norm($key); if (! $key) return;
	if (self::isAction($key, $val)) return;

	switch ($key) { // hiding passwords
		case "crdp": $val = STR::maskPwd($val); break;
	}
	return $_SESSION[APP_IDX][$key] = $val;
}

// ***********************************************************
private static function isAction($key, $val) {
	if ($key == "tan") return true; // do not store tans
	if ($key == "act") return true; // do not store pressed buttons
	if (STR::ends($key, "_act")) return true;
	return false;
}

// ***********************************************************
// dropping session vars
// ***********************************************************
public static function clearSVar($key = NV) {
	if ($key == NV)
    unset($_SESSION[APP_IDX]); else
	unset($_SESSION[APP_IDX][$key]);
}

private static function clrTimeOut() { // drop all stored vars ?
	$now = time();
    $vgl = self::get("timeout", $now);
	$xxx = self::set("timeout", $now + (TIMEOUT * 60));

	if ($vgl < $now) self::clearSVar(); // !!!!
}

// ***********************************************************
// handling form and request vars
// ***********************************************************
public static function getPostGrps($mask = "val_") {
	$key = self::norm($mask); $out = array();

	foreach ($_POST as $key => $val) {
		if (! STR::begins($key, $mask)) continue;
		$qid = STR::after($key, $mask);
		$out[$qid] = $val;
	}
	return $out;
}
public static function getPost($key, $default = false) {
	$key = self::norm($key);
	$out = VEC::get($_POST,  $key, NV); if ($out != NV) return $out;
	return VEC::get($_POST, "$key ", $default);
}
public static function getParm($key, $default = false) {
	$key = self::norm($key);
	return VEC::get($_GET, $key, $default);
}

public static function setParm($key, $value) {
	$key = self::norm($key);
	$_GET[$key] = $value;
}

public static function norm($key) {
	$key = STR::norm($key); $clr = str_split(".,: ");
	$key = STR::replace($key, $clr, "_");
	return $key;
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
// debugging
// ***********************************************************
public static function debug() {
	DBG::debug($_SESSION[APP_IDX]);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
