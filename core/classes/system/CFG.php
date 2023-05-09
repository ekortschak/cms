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
	private static $dat = array(); // constants
	private static $cfg = array(); // ini data
	private static $vls = array(); // buffer between .ini and .srv vars

public static function init() {
	self::fixForced(); // constants set before config.ini
	self::fixServer(); // constants derived from env
	self::fixPaths();
	self::fixLangs();  // defined languages

	self::readCfg();
}

// ***********************************************************
// appropriating server environment
// ***********************************************************
private static function fixForced() { // constants set by startup script
	$arr = get_defined_constants(true);
	$arr = $arr["user"];

	foreach ($arr as $key => $val) {
		self::$dat[$key] = $val;
	}
}

private static function fixServer() {
	self::set("SRV_ROOT", VEC::get($_SERVER, "DOCUMENT_ROOT", NV));
	self::set("SRV_ADDR", VEC::get($_SERVER, "SERVER_ADDR", "?.?.?.?"));
	self::set("SRV_NAME", VEC::get($_SERVER, "SERVER_NAME", "localhost"));
	self::set("SRV_PORT", VEC::get($_SERVER, "SERVER_PORT", "80"));
	self::set("SRV_PROT", VEC::get($_SERVER, "REQUEST_SCHEME", "http"));
	self::set("APP_FILE", VEC::get($_SERVER, "PHP_SELF", "unknown"));

	self::set("APP_CALL", self::getCaller(APP_FILE));
	self::set("APP_IDX",  self::getIndex());

	self::set("USER_IP",  VEC::get($_SERVER, "REMOTE_ADDR", 0));

	self::set("IS_LOCAL", STR::begins(SRV_ADDR, "127"));
}

private static function fixPaths() {
	if (! IS_LOCAL) return;

	$ck4 = "/xtools/ck4";
	$dir = FSO::join(SRV_ROOT, $ck4); if (is_dir($dir)) self::set("CK4_URL", $ck4);

	$ck5 = "/xtools/ck5";
	$dir = FSO::join(SRV_ROOT, $ck5); if (is_dir($dir)) self::set("CK5_URL", $ck5);
}

private static function fixLangs() {
	if (APP_IDX != "config.php") return;
	self::set("LANGUAGES", "de.en");
}

// ***********************************************************
// reading config files
// ***********************************************************
public static function readCfg() {
	$arr = APP::files("config", "*.ini");

	foreach ($arr as $fil => $nam) {
		self::read($fil);
	}
}

// ***********************************************************
public static function readCss() {
	self::read("LOC_CLR/default.ini");
	self::read("LOC_CLR/COLORS.ini");
	self::read("LOC_LAY/LAYOUT.ini");
}

// ***********************************************************
public static function read($file) {
	$fil = self::insert($file); // resolve constants in file names
	$fil = APP::file($fil);
	$srv = STR::replace($fil, ".ini", ".srv");

	if (! $fil) {
		if (! stripos($file, "config.ini")) return;
		die("Config file '$file' not found!");
	};

	self::load($fil); if (! IS_LOCAL)
	self::load($srv);

	foreach (self::$vls as $key => $val) {
		self::set($key, $val);
	}
}

// ***********************************************************
private static function load($fil) {
	if (! is_file($fil)) return;

	$arr = file($fil); $sec = "";
	$idx = FSO::name($fil);
	$vls = array();

	foreach ($arr as $lin) { // process lines
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
	$key = strtoupper(trim($key)); if (defined($key)) return;
	$val = trim($value); self::$dat[$key] = $val;

	if ($val === "false") $val = false;
	if ($val === "true")  $val = true;
	define($key, $val);
}

public static function setIf($key) {
	$key = strtoupper(trim($key)); if (defined($key)) return;
	$val = VEC::get($_GET, $key);  if (! $val) return;
	self::set($key, $val);
}

// ***********************************************************
// retrieving categories
// ***********************************************************
public static function groups() {
	$arr = get_defined_constants(true);
	return VEC::keys($arr);
}

// ***********************************************************
// replacing constants in strings
// ***********************************************************
public static function insert($out) {
	$arr = self::$dat; if (! $out) return $out;

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
public static function get($key, $default = "") {
	$key = strtoupper(trim($key)); if (! defined($key)) return $default;
	return constant($key);
}

public static function getCats() {
	$cst = get_defined_constants(true);
	$cst = array_keys($cst); ksort($cst); unset($cst["user"]);
	$out = array("user" => "USER", "" => "<hr>");
	return $out + $cst;
}

public static function getConsts($sec = "user") {
	$out = get_defined_constants(true); if ($sec)
	$out = $out[$sec]; ksort($out); if ($sec != "user") return $out;

	$out["DB_FILE"]  = "*****"; // hide critical info
	$out["DB_PASS"]  = "*****";
	$out["CUR_PASS"] = "*****";
	$out["SECRET"]   = "*****";

	return $out;
}

// ***********************************************************
// retrieving config vars
// ***********************************************************
public static function getVars($idx, $pfx = "") {
	$arr = VEC::get(self::$cfg, $idx);
	return VEC::match($arr, $pfx);
}

public static function getVar($idx, $key, $default = "") {
	$out = VEC::get(self::$cfg, $idx); if (! $out) return $default;
	return VEC::get($out, $key, $default);
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private static function getCaller($file) {
	$fil = basename($file);
	if (STR::begins($fil, "x.")) return "index.php";
	return $fil;
}

private static function getIndex() {
	if (! STR::contains(APP_FILE, "x.edit")) return APP_FILE;
	return STR::replace(APP_FILE, "x.edit", "index");
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
