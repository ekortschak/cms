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

CFG::set("CONST", $value);

$val = CFG::get("CONST", $default);
$val = CFG::get("inifile:section.$key", $default);

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
	CFG::set("SRV_ADDR", VEC::get($_SERVER, "SERVER_ADDR"));
	CFG::set("SRV_NAME", VEC::get($_SERVER, "SERVER_NAME", "localhost"));
	CFG::set("SRV_PORT", VEC::get($_SERVER, "SERVER_PORT", "80"));
	CFG::set("SRV_PROT", VEC::get($_SERVER, "REQUEST_SCHEME", "http"));
	CFG::set("USER_IP",  VEC::get($_SERVER, "REMOTE_ADDR", "?.?.?.?"));

	CFG::set("IS_LOCAL", CFG::isLocal(SRV_ADDR));
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
	CFG::read("LOC_DIM/default.ini");
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
		CFG::suggest($key, $val);
	}
}

// ***********************************************************
// handling "temporary" constants
// ***********************************************************
private static function suggest($key, $val) { // suggest value for constant
	CFG::set($key, $val, false);
}

private static function freeze() {
	foreach (CFG::$dat as $key => $val) {
		if (defined($key)) continue;
		define($key, $val); // valid constant definition
	}
}

// ***********************************************************
// setting values
// ***********************************************************
public static function update($idx, $val) {
	CFG::$cfg[$idx] = $val; // set config var
}

public static function set($key, $value, $permanent = true) {
	if ( ! CFG::chkKey($key)) return;
	$val = CFG::chkVal($value);

	CFG::$dat[$key] = $val; // set constant
	if ($permanent) define($key, $val);
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
		$out = STR::replace($out, "\\$key", "\\$msk");
// substitute remaining constants by their values
		$out = preg_replace("~\b$key\b~", $val, $out);
// restore protected constants
		$out = STR::replace($out, $msk, $key);
	}
	return $out;
}

public static function unescape($text) {
	if (! $text) return ""; $out = $text;

	foreach (CFG::$dat as $key => $val) {
		$out = STR::replace($out, "\\$key", $key);
	}
	return $out;
}

public static function encode($dir) { // directory constants only
	$dir = STR::replace($dir, APP_DIR, "\APP_DIR");
	$dir = STR::replace($dir, FBK_DIR, "\FBK_DIR");
	$dir = STR::replace($dir, PRJ_DIR, "\PRJ_DIR");
	$dir = STR::replace($dir, DOM_DIR, "\DOM_DIR");

	foreach (CFG::$dat as $key => $val) {
		if ( ! STR::begins($key, "LOC_")) continue;
		$dir = STR::replace($dir, $val, "\\$key");
	}
	return $dir;
}

// ***********************************************************
// retrieving constants
// ***********************************************************
public static function cats() {
	$cst = get_defined_constants(true);
	$cst = VEC::keys($cst); VEC::sort($cst); unset($cst["user"]);
	$out = array("user" => "user", "" => "<hr>");
	return $out + $cst;
}

public static function constants($sec = "user") {
	$all = get_defined_constants(true);
	$arr = VEC::get($all, $sec); if (! $arr) return $all;
	$arr = VEC::sort($arr); if ($sec != "user") return $arr;
	$out = array();

	$arr["DB_FILE"]  = "*****"; // hide critical info
	$arr["DB_PASS"]  = "*****";
	$arr["CUR_PASS"] = "*****";

	foreach ($arr as $key => $val) {
		$out["\\$key"] = $val;
	}
	return $out;
}

public static function constant($key, $default = false) {
	if (! defined($key)) return $default;
	return constant($key);
}

// ***********************************************************
// retrieving ini values
// ***********************************************************
public static function match($pfx = "") {
	return VEC::match(CFG::$cfg, $pfx);
}

public static function get($key, $default = "") { // $key - format: file:sec.value
	return VEC::get(CFG::$cfg, $key, $default);
}
public static function mod($key) {
	return CFG::get("mods:$key");
}

// ***********************************************************
// auxilliary methods
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
// debugging
// ***********************************************************
public static function dump() {
	DBG::tview(CFG::$dat);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
