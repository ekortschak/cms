<?php
/* ***********************************************************
// INFO
// ***********************************************************
contains static functions for handling
* constants before their final definition

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("system/KONST.php");

*/

KONST::init();

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class KONST {
	private static $dat = array();

public static function init() {
	self::set("DIR_SEP", "/");
	self::set("NV", "N/A");
	self::set("HIDE", "~");
	self::set("CUR_DATE", date("Y/m/d"));
	self::set("CUR_YEAR", date("Y"));

	self::fixForced(); // constants set before config.ini
	self::fixServer();
}

// ***********************************************************
// appropriating server environment
// ***********************************************************
private static function fixForced() {
	if (defined("SRV_ROOT")) self::$dat["SRV_ROOT"] = SRV_ROOT;

	if (defined("LAYOUT")) self::$dat["LAYOUT"] = LAYOUT;
	if (defined("COLORS")) self::$dat["COLORS"] = COLORS;
}

private static function fixServer() {
	self::set("SRV_NAME", VEC::get($_SERVER, "SERVER_NAME", "localhost"));
	self::set("SRV_PORT", VEC::get($_SERVER, "SERVER_PORT", "80"));
	self::set("SRV_PROT", VEC::get($_SERVER, "REQUEST_SCHEME", "http"));
	self::set("APP_FILE", VEC::get($_SERVER, "PHP_SELF", "unknown"));

	self::set("APP_NAME", basename(APP_DIR));
	self::set("APP_CALL", basename(APP_FILE));

	self::set("IS_LOCAL", SRV_NAME == "localhost");
}

public static function roundup() {
	self::set("DB_CON", "none");
	self::set("DB_LOGIN", false);
	self::set("DB_ADMIN", false);
}

// ***********************************************************
// reading config files
// ***********************************************************
public static function read($file) {
	$fil = self::insert($file); // needed for LAYOUT and COLORS
	$fil = APP::file($fil);

	if (! $fil) {
		if (! stripos($file, "config.ini")) return;
		die("Config file '$file' not found!");
	};
	$arr = file($fil);

	foreach ($arr as $lin) {
		$lin = STR::dropComments($lin); if (! strpos($lin, "=")) continue;

		$itm = explode("=", $lin);
		$key = $itm[0]; if ($key != strtoupper($key)) continue; // no valid constant name
		$val = $itm[1];

		self::set($key, self::insert($val));
	}
}

// ***********************************************************
// setting and retrieving values
// ***********************************************************
public static function set($key, $value) {
	$key = trim($key); if (defined($key)) return; if ($key < "A") return;
	$val = trim($value); self::$dat[$key] = $val;
	define($key, $val);
}
public static function get($key, $default = "") {
	$key = trim($key); if (! defined($key)) return $default;
	return constant($key);
}

public static function check($key) {
	$val = VEC::get($_GET, $key); if (! $val) return;
	$key = strtoupper($key);
	self::set($key, $val);
}

// ***********************************************************
// retrieving categories
// ***********************************************************
public static function groups() {
	$arr = get_defined_constants(true);
	$out = array_keys($arr);
	return array_combine($out, $out);
}

// ***********************************************************
// replacing constants in strings
// ***********************************************************
public static function insert($out) {
	$arr = self::$dat;

	foreach ($arr as $key => $val) {
		if (! $key) continue;
		if ($key == "NV") continue;
		$out = preg_replace("~\b$key\b~", $val, $out);
	}
	return $out;
}

// ***********************************************************
// retrieving constants
// ***********************************************************
public static function getList($sec = "user") {
	$out = get_defined_constants(true); if ($sec)
	$out = $out[$sec]; ksort($out);

	$out["DB_FILE"]  = "*****"; // hide passwords
	$out["DB_PASS"]  = "*****";
	$out["CUR_PASS"] = "*****";
	$out["SECRET"]   = "*****";

	if (! DB_CON) { // remove db constants
		unset($out["DB_ADMIN"]);
		unset($out["DB_LOGIN"]);
	}
	if (MAILMODE == "none") { // remove mail constants
		unset($out["MAILMODE"]);
		unset($out["POSTMASTER"]);
		unset($out["TESTMASTER"]);
		unset($out["NOREPLY"]);
	}
	return $out;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
