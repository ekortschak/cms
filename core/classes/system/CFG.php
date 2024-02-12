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

	private static $msk = "¬@¬";

public static function init() {
	CFG::addForced(); // constants set before config.ini
	CFG::addServer(); // constants derived from emv

	CFG::initCfg();   // read default values for constants
	CFG::readCfg();   // read inifiles
}

// ***********************************************************
// assessing server environment
// ***********************************************************
private static function addForced() { // constants set by startup script
	$arr = get_defined_constants(true);

	foreach ($arr["user"] as $key => $val) {
		CFG::$dat[$key] = $val;
	}
}

private static function addServer() {
	CFG::set("SRV_ADDR", VEC::get($_SERVER, "SERVER_ADDR", "?.?.?.?"));
	CFG::set("SRV_NAME", VEC::get($_SERVER, "SERVER_NAME", "localhost"));
	CFG::set("SRV_PORT", VEC::get($_SERVER, "SERVER_PORT", "80"));
	CFG::set("SRV_PROT", VEC::get($_SERVER, "REQUEST_SCHEME", "http"));
	CFG::set("USER_IP",  VEC::get($_SERVER, "REMOTE_ADDR", 0));

	CFG::set("IS_LOCAL", self::isLocal(SRV_ADDR));
}

// ***********************************************************
// reading config files
// ***********************************************************
public static function initCfg() {
	CFG::read("core/include/internals.ini");
	CFG::read("core/include/defaults.ini");
}

public static function readCfg() {
	$arr = APP::files("config", "*.ini");

	foreach ($arr as $fil => $nam) {
		CFG::read($fil);
	}
	CFG::read("LOC_CLR/default.ini");
	CFG::read("LOC_CLR/COLORS.ini");
	CFG::read("LOC_DIM/SSHEET.ini");
	CFG::freeze();
}

// ***********************************************************
private static function read($file) {
	$fil = APP::file($file); if (! $fil) return;
	$srv = STR::replace($fil, ".ini", ".srv");

	CFG::load($fil); if (! IS_LOCAL)
	CFG::load($srv);
}

// ***********************************************************
private static function load($fil) {
	if (! is_file($fil)) return;

	$arr = file($fil); $sec = "";
	$idx = FSO::name($fil);

	foreach ($arr as $lin) { // process lines
		$lin = STR::dropComments($lin);

		if (STR::begins($lin, "[")) $sec = STR::between($lin, "[", "]");
		if (STR::misses($lin, "=")) continue;

		$key = STR::before($lin, "="); if (! $key) continue;
		$val = STR::after( $lin, "=");

		CFG::update("$idx:$sec.$key", $val);
		CFG::preset($key, $val);
	}
}

private static function freeze() {
	foreach (CFG::$dat as $key => $val) {
		CFG::set($key, $val); // valid constant definition
	}
}

// ***********************************************************
// setting values
// ***********************************************************
public static function update($idx, $val) {
	CFG::$cfg[$idx] = $val; // set config var
}

public static function set($key, $value) {
	if ( ! CFG::chkKey($key)) return;
	$val = CFG::chkVal($value);

	CFG::$dat[$key] = $val; // set constant
	define($key, $val);
}

private static function preset($key, $val) { // suggest value for constant
	if ( ! CFG::chkKey($key)) return;
	$val = CFG::chkVal($val);
	CFG::$dat[$key] = $val;
}

// ***********************************************************
private static function chkKey($key) {
	if (strtoupper($key) !== $key) return false;
	if (defined($key)) return false;
	return $key;
}
private static function chkVal($val) {
	$val = trim($val);
	if ($val === "false") return false;
	if ($val === "true")  return true;
	return $val;
}

// ***********************************************************
// setting CUR_DEST
// ***********************************************************
public static function setDest($mod) {
	switch ($mod) {
		case "csv": $dst = "csv"; break; // retrieve data only
		case "prn": $dst = "prn"; break; // printing and pdf
		default:    $dst = "screen";
	}
	CFG::set("CUR_DEST", $dst);
}

// ***********************************************************
// replacing constants in strings
// ***********************************************************
public static function apply($text) {
	if (! $text) return ""; $out = $text; $msk = CFG::$msk;

	foreach (CFG::$dat as $key => $val) {
		if ($key == "NV") continue;

// protect constant definitions (e.g. ini files)
		$out = preg_replace("~\n$key(\s?)=(\s?)~", "\n$msk = ", $out);
// protect masked/escaped constants (preceeded by "\");
		$out = STR::replace($out, "\\$key", $msk);
// substitute remaining constants by their values
		$out = preg_replace("~\b$key\b~", $val, $out);
// restore protected constants
		$out = STR::replace($out, $msk, $key);
	}
	return $out;
}

public static function unmask($text) {
	if (! $text) return ""; $out = $text;

	foreach (CFG::$dat as $key => $val) {
		$out = STR::replace($out, "\\$key", $key);
	}
	return $out;
}

public static function encode($dir) {
	$dir = STR::replace($dir, APP_DIR.DIR_SEP, "APP_DIR".DIR_SEP);
	$dir = STR::replace($dir, FBK_DIR.DIR_SEP, "FBK_DIR".DIR_SEP);
	$dir = STR::replace($dir, PRJ_DIR.DIR_SEP, "PRJ_DIR".DIR_SEP);
	$dir = STR::replace($dir, TOP_DIR.DIR_SEP, "TOP_DIR".DIR_SEP);

	foreach (CFG::$dat as $key => $val) {
		if ( ! STR::begins($key, "LOC_")) continue;
		$dir = STR::replace($dir, $val, $key);
	}
	return $dir;
}

// ***********************************************************
// retrieving info
// ***********************************************************
private static function isLocal($srv) {
	if (STR::begins($srv, "127")) return true;
	if (STR::begins($srv, "::1")) return true;
	return false;
}

public static function dbState($sec = "main") { // tpl section
	if (! DB_MODE)  return "nodb";
	if (! DB_CON)   return "nocon";
	if (! DB_LOGIN) return "nouser";
	return $sec;
}

// ***********************************************************
// retrieving constants
// ***********************************************************
public static function cats() {
	$cst = get_defined_constants(true);
	$cst = array_keys($cst); ksort($cst); unset($cst["user"]);
	$out = array("user" => "USER", "" => "<hr>");
	return $out + $cst;
}

public static function constants($sec = "user") {
	$out = get_defined_constants(true); if ($sec)
	$out = $out[$sec]; ksort($out); if ($sec != "user") return $out;

	$out["DB_FILE"]  = "*****"; // hide critical info
	$out["DB_PASS"]  = "*****";
	$out["CUR_PASS"] = "*****";

	return $out;
}

public static function constant($key, $default = "") {
	if (! defined($key)) return $default;
	return constant($key);
}

// ***********************************************************
// retrieving config vars
// ***********************************************************
public static function iniGroup($pfx = "") {
	return VEC::match(CFG::$cfg, $pfx);
}

public static function iniVal($idx, $default = "") { // $idx - format: file:sec.value
	return VEC::get(CFG::$cfg, $idx, $default);
}

public static function mod($key) {
	return CFG::iniVal("mods:$key");
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
