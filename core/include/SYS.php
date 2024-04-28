<?php
/* ***********************************************************
// INFO
// ***********************************************************
* contains (only) most basic functions
* requires fallback.php
*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class SYS {

// ***********************************************************
// methods
// ***********************************************************
public static function file($file) {
	$out = APP_DIR."/$file"; if (is_file($out)) return $out;
	$out = FBK_DIR."/$file"; if (is_file($out)) return $out;
	return $file;
}

// ***********************************************************
// startup file
// ***********************************************************
public static function startFile($vmode) {
	$inc = SYS::getFile($vmode);
	return SYS::file("core/$inc.php");
}

private static function getFile($vmode) {
	if (substr($vmode, 1) == "edit") return "edit";

	if ($vmode == "xlate") return "edit";
	if ($vmode == "xfer")  return "edit";
	if ($vmode == "seo")   return "edit";

	if ($vmode == "pres")  return "pres";
	return "index";
}

// ***********************************************************
// environment vars
// ***********************************************************
public static function get($key, $default = false) {
	$val = SYS::findVal($key, $default);
	$_SESSION[APP_NAME][$key] = $val;
	return $val;
}
private static function findVal($key, $default) {
	if (isset ($_GET[$key]))               return $_GET[$key];
	if (isset ($_SESSION[APP_NAME][$key])) return $_SESSION[APP_NAME][$key];
	return $default;
}

public static function debug() {
	error_reporting(E_ALL);

	ini_set("display_startup_errors", true);
	ini_set("display_errors", true);
}

// ***********************************************************
// restrictions
// ***********************************************************
public static function forceAdmin() { // force login of admin
	if (! FS_ADMIN) ENV::setParm("dmode", "login");
}
public static function forceLogin() { // force login of any user
	if (CUR_USER == "www") ENV::setParm("dmode", "login");
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
