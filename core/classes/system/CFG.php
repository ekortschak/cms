<?php
/* ***********************************************************
// INFO
// ***********************************************************
contains static functions for handling
* constants before their final definition

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("system/CFG.php");

*/

CFG::init();

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class CFG {
	private static $dat = array();
	private static $cfg = array();
	private static $vls = array();

public static function init() {
	define("DIR_SEP", "/");
	define("NV", "N/A");
	define("HIDE", "~");
	define("CUR_DATE", date("Y/m/d"));
	define("CUR_YEAR", date("Y"));

	define("FILE_XS", 0775);

	self::fixForced(); // constants set before config.ini
	self::fixServer();
}

// ***********************************************************
// appropriating server environment
// ***********************************************************
private static function fixForced() {
	$arr = get_defined_constants(true);
	$arr = $arr["user"];

	foreach ($arr as $key => $val) {
		self::$dat[$key] = $val;
	}
}

private static function fixServer() {
	self::set("SRV_NAME", VEC::get($_SERVER, "SERVER_NAME", "localhost"));
	self::set("SRV_PORT", VEC::get($_SERVER, "SERVER_PORT", "80"));
	self::set("SRV_PROT", VEC::get($_SERVER, "REQUEST_SCHEME", "http"));
	self::set("APP_FILE", VEC::get($_SERVER, "PHP_SELF", "unknown"));

	self::set("APP_NAME", basename(APP_DIR));
	self::set("APP_CALL", self::getCaller(APP_FILE));

	self::set("IS_LOCAL", SRV_NAME == "localhost");
}

// ***********************************************************
// reading config files
// ***********************************************************
public static function read($file) {
	$fil = self::insert($file); // resolve constants in file names
	$fil = APP::file($fil);

	if (! $fil) {
		if (! stripos($file, "config.ini")) return;
		die("Config file '$file' not found!");
	};
	self::readCfg($fil); if (! IS_LOCAL)
	self::readCfg(STR::replace($fil, ".ini", ".srv"));

	foreach (self::$vls as $key => $val) {
		self::set($key, $val);
	}
}

private static function readCfg($fil) {
	if (! is_file($fil)) return;
	$arr = file($fil); $sec = "";
	$idx = STR::before(basename($fil), ".");
	$vls = array();

	foreach ($arr as $lin) {
		$lin = STR::dropComments($lin);

		if (STR::begins($lin, "[")) $sec = STR::between($lin, "[", "]");
		if (STR::misses($lin, "=")) continue;

		$key = STR::before($lin, "=");
		$val = STR::after($lin, "=");

		if ($key != strtoupper($key)) { // no valid constant name
			self::$cfg[$idx]["$sec.$key"] = $val;
		}
		else {
			self::$vls[$key] = self::insert($val);
		}
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

public static function getCfg($idx, $filter = false) {
	$out = VEC::get(self::$cfg, $idx); if ($filter)
	$out = VEC::match($out, $filter);
	return $out;
}

public static function getVar($idx, $key, $default = "") {
	$key = trim($key);
	$out = VEC::get(self::$cfg, $idx); if (! $out) return $default;
	return VEC::get($out, $key, $default);
}

protected static function getCaller($file) {
	$fil = basename($file);
	if (STR::begins($fil, "x.")) return "index.php";
	return $fil;
}

// ***********************************************************
// retrieving constants
// ***********************************************************
public static function dump($idx = false) {
	$arr = self::$cfg; if ($idx)
	$arr = self::$cfg[$idx];

	DBG::vector($arr);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
