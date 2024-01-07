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
	CFG::addForced(); // constants set before config.ini
	CFG::addServer(); // constants derived from env

	CFG::set("TAB_SET", "default"); // should be set already

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
	CFG::set("APP_ROOT", dirname(APP_DIR));
	CFG::set("DOC_ROOT", VEC::get($_SERVER, "DOCUMENT_ROOT", APP_ROOT));

	CFG::set("SRV_ADDR", VEC::get($_SERVER, "SERVER_ADDR", "?.?.?.?"));
	CFG::set("SRV_NAME", VEC::get($_SERVER, "SERVER_NAME", "localhost"));
	CFG::set("SRV_PORT", VEC::get($_SERVER, "SERVER_PORT", "80"));
	CFG::set("SRV_PROT", VEC::get($_SERVER, "REQUEST_SCHEME", "http"));
	CFG::set("USER_IP",  VEC::get($_SERVER, "REMOTE_ADDR", 0));

	CFG::set("IS_LOCAL", self::getLocal(SRV_ADDR));
}

// ***********************************************************
// reading config files
// ***********************************************************
public static function readCfg() {
	$arr = APP::files("config", "*.ini");

	foreach ($arr as $fil => $nam) {
		CFG::read($fil);
	}
	CFG::freeze();
}

// ***********************************************************
public static function readCss() {
	CFG::read("LOC_CLR/default.ini");
	CFG::read("LOC_CLR/COLORS.ini");
	CFG::read("LOC_DIM/LAYOUT.ini");

	CFG::freeze();
}

// ***********************************************************
private static function read($file) {
	$fil = CFG::apply($file); // resolve constants in file names
	$fil = APP::file($fil); if (! $fil) return;
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
		$val = STR::after($lin, "=");

		CFG::setVal("$idx:$sec.$key", $val);
	}
}

private static function freeze() {
	foreach (CFG::$cfg as $idx => $val) {
		$key = STR::after($idx, "."); if ($key != strtoupper($key)) continue;
		CFG::set($key, $val); // valid constant definition
	}
}

// ***********************************************************
// setting values
// ***********************************************************
public static function set($key, $value) {
	$key = strtoupper(trim($key)); if (defined($key)) return;
	$val = trim(CFG::apply($value));

	if ($val === "false") $val = false;
	if ($val === "true")  $val = true;

	CFG::$dat[$key] = $val;
	define($key, $val);
}

public static function setIf($key) {
	$key = strtoupper(trim($key)); if (defined($key)) return;
	$val = VEC::get($_GET, $key);  if (! $val) return;
	CFG::set($key, $val);
}

public static function setVal($idx, $val) {
#if (STR::contains($idx, "tabsets")) echo "<li>$idx - $val";
	CFG::$cfg[$idx] = $val;
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
	$out = $text; if (! $out) return "";

	foreach (CFG::$dat as $key => $val) {
		if (! $key) continue;
		if ($key == "NV") continue;
		$out = preg_replace("~\b$key\b~", $val, $out);
	}
	return $out;
}

public static function encode($text) {
	foreach (CFG::$dat as $key => $val) {
		if (! STR::begins($key, array("APP_", "LOC_"))) continue;
		$text = preg_replace("~$val~", $key, $text);
	}
	return $text;
}

// ***********************************************************
public static function restore($text) {
	$out = CFG::contains($text, "APP_FBK");  if ($out) return $out;
	$out = CFG::contains($text, "APP_DIR");  if ($out) return $out;
	$out = CFG::contains($text, "APP_ROOT"); if ($out) return $out;
	return $text;
}

private static function contains($text, $var) {
	$cfg = CFG::getConst($var);
	if ( ! STR::begins ($text, $cfg)) return false;
	return STR::replace($text, $cfg, $var);
}

// ***********************************************************
// retrieving categories
// ***********************************************************
public static function groups() {
	$arr = get_defined_constants(true);
	return VEC::keys($arr);
}

// ***********************************************************
// retrieving db state
// ***********************************************************
public static function dbState($sec = "main") { // tpl section
	if (! DB_MODE)  return "nodb";
	if (! DB_CON)   return "nocon";
	if (! DB_LOGIN) return "nouser";
	return $sec;
}

// ***********************************************************
// retrieving constants
// ***********************************************************
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

	return $out;
}

public static function getConst($key, $default = "") {
	if (! defined($key)) return $default;
	return constant($key);
}

private static function getLocal($srv) {
	if (STR::begins($srv, "127")) return true;
	if (STR::begins($srv, "::1")) return true;
	return false;
}

// ***********************************************************
// retrieving config vars
// ***********************************************************
public static function getValues($pfx = "") {
	return VEC::match(CFG::$cfg, $pfx);
}

public static function getVal($idx, $default = "") { // $idx - format: file:sec.value
	return VEC::get(CFG::$cfg, $idx, $default);
}

public static function mod($key) {
	return CFG::getVal("mods:$key");
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
