<?php
/* ***********************************************************
// INFO
// ***********************************************************
used to track "most recent values" in html input-objects
 * such as selectors and db-records ...

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("system/OID.php");

$obj = new OID();
*/

OID::init();

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class OID {
	private static $vrs = false; // address of app's session vars
	private static $top = false; // address of oid vars
	private static $cnt = 100;

public static function init() {
	$oid = ENV::getPost("oid", "dummy");

	self::$vrs = &$_SESSION[APP_IDX]; if (! isset(self::$vrs["oid"])) self::$vrs["oid"] = array();
	self::$top = &self::$vrs["oid"];  if (! isset(self::$top[$oid ])) self::$top[$oid]  = array();

	self::chkPost($_POST, self::$top, $oid);
}

// ***********************************************************
// register an object
// ***********************************************************
public static function register($key = NV, $sfx = "'") {
	if ($key == NV) {
		$pge = ENV::get("loc", "none");
		$key = "$pge.$sfx.".self::$cnt++;
	}
	if (strlen($key) != 32) $key = md5($key);

	return $key;
}

private static function chkPost($arr, &$vec, $sec) {
	if (! isset($vec[$sec])) $vec[$sec] = array();

	foreach ($arr as $key => $val) {
		if ($key == "oid") continue;
		if (STR::ends($key, "act")) continue;

		if (is_array($val)) {
			self::chkPost($val, $vec[$sec], $key);
			continue;
		}
		$vec[$sec][$key] = trim($val);
	}
}

// ***********************************************************
// setting & retrieving oid values
// ***********************************************************
public static function get($oid, $key, $default = false) {
	$key = SSV::norm($key);
	$idx = STR::between($key,"[", "]");
	$key = STR::before($key, "[");

	$arr = self::isOid($oid);              if (! $arr) return $default;
	$out = VEC::get($arr, $key, $default); if (! $idx) return $out;
	return VEC::get($out, $idx, $default);
}

public static function set($oid, $key, $value) {
	$key = SSV::norm($key);
	$idx = STR::between($key,"[", "]");
	$key = STR::before($key, "[");

	if (! $idx)
	self::$top[$oid][$key] = $value; else
	self::$top[$oid][$key][$idx] = $value;
	return $value;
}

public static function setIf($oid, $key, $value) {
	$chk = self::get($oid, $key, NV); if ($chk !== NV) return $chk;
	return self::set($oid, $key, $value);
}

private static function isOid($oid) {
	if (! $oid) return false;
	return VEC::get(self::$top, $oid);
}

// ***********************************************************
public static function update($oid, $key, $value) {
	$idx = "$oid.$key";
	$val = SSV::get($idx, NV); if ($val === $value) return false;
	$xxx = SSV::set($idx, $value);
	return true;
}

// ***********************************************************
public static function getLast($oid = false) {
	if (! $oid) $oid = ENV::getPost("oid");
	return self::isOid($oid);
}

// ***********************************************************
public static function getValues($oid) {
	return self::isOid($oid);
}

// ***********************************************************
// cleansing
// ***********************************************************
public static function forget($oid = NV) {
	if ($oid == NV) self::$top = array();
	else            self::$top[$oid] = array();
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
