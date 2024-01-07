<?php

// ***********************************************************
// find files or default to fallback dir
// ***********************************************************
function incCls($file) { appInclude(LOC_CLS."/$file"); }
function incMod($file) { appInclude(LOC_MOD."/$file"); }
function incFnc($file) { appInclude(LOC_INC."/$file"); }

// ***********************************************************
function appInclude($file) {
	include_once appFile($file);
}
function appFile($file) {
	$ful = APP_DIR."/$file"; if (is_file($ful)) return $ful;
	$ful = APP_FBK."/$file"; if (is_file($ful)) return $ful;
	return $file;
}

// ***********************************************************
// startup functions
// ***********************************************************
function appVar($key, $default) {
	$out = appVarValue($key, $default);
	$_SESSION[APP_DIR][$key] = $out;
	return $out;
}
function appVarValue($key, $default) {
	if (isset ($_GET[$key]))              return $_GET[$key];
	if (isset ($_SESSION[APP_DIR][$key])) return $_SESSION[APP_DIR][$key];
	return $default;
}
function appMode($mod) {
	$fil = appFile("core/$mod.php");
	if (is_file($fil)) return $mod;
	return "index";
}

// ***********************************************************
// goodies
// ***********************************************************
function checkStop() { // force execution to stop
	$fil = FSO::join(APP_DIR, "x.stop");
	if (is_file($fil)) die("Execution halted!");
}

function requireAdmin() { // force login of admin
	if (! FS_ADMIN) ENV::setParm("dmode", "login");
}
function requireLogin() { // force login of any user
	if (CUR_USER == "www") ENV::setParm("dmode", "login");
}

// ***********************************************************
// debug
// ***********************************************************
function dbgli($msg = "hier", $info = "dbg") { // show plain text
	echo "<li>$info: $msg</li>";
}

function dbgpi($msg = "hier", $info = "dbg") { // show plain text
	$msg = STR::replace($msg, DIR_SEP, " / ");
	echo "<li>$info: $msg</li>";
}

?>
