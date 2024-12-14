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

$oid = OID::register();
$val = OID::set($oid, $key, $val);
$val = OID::get($oid, $key, $default);

$arr = OID::values();

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
	$oid = ENV::getPost("oid", NV);

	OID::$vrs = &$_SESSION[APP_NAME]; if (! isset(OID::$vrs["oid"])) OID::$vrs["oid"] = array();
	OID::$top = &OID::$vrs["oid"];    if (! isset(OID::$top[$oid ])) OID::$top[$oid]  = array();

	OID::chkPost($_POST, OID::$top, $oid);
}

// ***********************************************************
// register an object
// ***********************************************************
public static function register($key = NV, $sfx = "'") {
	if ($key === NV) {
		$key = PGE::$dir.".$sfx.".OID::$cnt++;
	}
	if (strlen($key) != 32) $key = md5($key);
	return $key;
}

private static function chkPost($arr, &$vec, $oid) {
	if (! isset($vec[$oid])) $vec[$oid] = array();

	foreach ($arr as $key => $val) {
		if ($key == "oid") continue; // no need for duplication
		if (STR::ends($key, "act")) continue; // do not store nav

		if (is_array($val)) {
			OID::chkPost($val, $vec[$oid], $key);
			continue;
		}
		$vec[$oid][$key] = trim($val);
	}
}

// ***********************************************************
// setting & retrieving oid values
// ***********************************************************
public static function get($oid, $key, $default = false) {
	$key = SSV::norm($key);
	$idx = STR::between($key,"[", "]");
	$key = STR::before($key, "[");

	$arr = OID::values($oid);              if (! $arr) return $default;
	$out = VEC::get($arr, $key, $default); if (! $idx) return $out;
	return VEC::get($out, $idx, $default);
}

public static function set($oid, $key, $value) {
	$key = SSV::norm($key);
	$idx = STR::between($key,"[", "]");
	$key = STR::before($key, "[");

	if (! $idx)
	OID::$top[$oid][$key] = $value; else
	OID::$top[$oid][$key][$idx] = $value;
	return $value;
}

public static function setIf($oid, $key, $value) {
	$chk = OID::get($oid, $key, NV); if ($chk !== NV) return $chk;
	return OID::set($oid, $key, $value);
}

// ***********************************************************
public static function values($oid = false) {
	if (! $oid) $oid = ENV::getPost("oid");
 	return VEC::get(OID::$top, $oid);
}

// ***********************************************************
// cleansing
// ***********************************************************
public static function forget($oid = NV) {
	if ($oid === NV) OID::$top = array();
	else            OID::$top[$oid] = array();
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
