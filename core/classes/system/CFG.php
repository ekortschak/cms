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

define("DIR_SEP", "/");
define("NV", "N/A");
define("HIDE", "~");

define("CUR_DATE", date("Y/m/d"));
define("CUR_YEAR", date("Y"));

define("FS_PERMS", 0775);

define("ICONS",   "core/icons");
define("LOC_DIC", "design/dictionary");
define("LOC_LAY", "design/layout");
define("LOC_CSS", "design/styles");
define("LOC_CFG", "design/config");
define("LOC_CLR", "design/colors");
define("LOC_TPL", "design/templates");
define("LOC_BTN", "design/buttons");

CFG::init();

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class CFG {
	private static $dat = array();
	private static $cfg = array();
	private static $vls = array();

public static function init() {
	self::fixForced(); // constants set before config.ini
	self::fixServer();
	self::fixPaths();

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
	self::set("SRV_ADDR", VEC::get($_SERVER, "SERVER_ADDR", "?.?.?.?"));
	self::set("SRV_NAME", VEC::get($_SERVER, "SERVER_NAME", "localhost"));
	self::set("SRV_PORT", VEC::get($_SERVER, "SERVER_PORT", "80"));
	self::set("SRV_PROT", VEC::get($_SERVER, "REQUEST_SCHEME", "http"));
	self::set("APP_FILE", VEC::get($_SERVER, "PHP_SELF", "unknown"));

	self::set("APP_NAME", basename(APP_DIR));
	self::set("APP_CALL", self::getCaller(APP_FILE));
	self::set("APP_IDX",  self::getIndex());

	self::set("IS_LOCAL", STR::begins(SRV_ADDR, "127"));
}

private static function fixPaths() {
	if (! IS_LOCAL) return;

	$rut = SRV_ROOT;

	$dir = "xtools/ck4"; if (is_dir("$rut/$dir")) self::set("CK4_URL", "/$dir");
	$dir = "xtools/ck5"; if (is_dir("$rut/$dir")) self::set("CK5_URL", "/$dir");
}

// ***********************************************************
// reading config files
// ***********************************************************
public static function readCfg() {
	$arr = FSO::files("config/*.ini");

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

	if (! $fil) {
		if (! stripos($file, "config.ini")) return;
		die("Config file '$file' not found!");
	};
	self::load($fil); if (! IS_LOCAL)
	self::load(STR::replace($fil, ".ini", ".srv"));

	foreach (self::$vls as $key => $val) {
		self::set($key, $val);
	}
}

// ***********************************************************
private static function load($fil) {
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
	$key = strtoupper(trim($key)); if (defined($key)) return;
	$val = trim($value); self::$dat[$key] = $val;
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
public static function get($key, $default = "") {
	$key = strtoupper(trim($key)); if (! defined($key)) return $default;
	return constant($key);
}

public static function getCats() {
	$cst = get_defined_constants(true);
	$cst = VEC::keys($cst); ksort($cst); unset($cst["user"]);
	$out = array("user" => "USER", "" => "<hr>");
	return $out + $cst;
}

public static function getData($sec = "user") {
	$out = get_defined_constants(true); if ($sec)
	$out = $out[$sec]; ksort($out); if ($sec != "user") return $out;

	$out["DB_FILE"]  = "*****"; // hide critical info
	$out["DB_PASS"]  = "*****";
	$out["CUR_PASS"] = "*****";
	$out["SECRET"]   = "*****";

	return $out;
}

public static function recall($sec) {
	return self::$cfg[$sec];
}

// ***********************************************************
// retrieving config vars
// ***********************************************************
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
