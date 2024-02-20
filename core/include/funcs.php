<?php

// ***********************************************************
// find files or default to fallback dir
// ***********************************************************
function incCls($file) {
	appInclude(LOC_CLS."/$file");
}

function appInclude($file) {
	include_once appFile($file);
}
function appFile($file) {
	$ful = APP_DIR."/$file"; if (is_file($ful)) return $ful;
	$ful = FBK_DIR."/$file"; if (is_file($ful)) return $ful;
	return $file;
}

// ***********************************************************
// startup functions
// ***********************************************************
function appVar($key, $default) {
	$val = appVarValue($key, $default);
	$_SESSION[APP_NAME][$key] = $val;
	return $val;
}
function appVarValue($key, $default) {
	if (isset ($_GET[$key]))               return $_GET[$key];
	if (isset ($_SESSION[APP_NAME][$key])) return $_SESSION[APP_NAME][$key];
	return $default;
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
function dbg($msg = "hier", $info = "dbg") { // show plain text
	if (class_exists("DBG")) {
		return DBG::text($msg, $info);
	}
	echo "<pre>$info: ".print_r($msg, true)."</pre>";
}

function dbgpi($path = "hier", $info = "dbg") { // show plain text
	$msg = CFG::encode($path);
	echo "<pre>$info: ".print_r($msg, true)."</pre>";
}

function dbx($msg, $info = "aborting") {
	echo "<pre>$info: ".print_r($msg, true)."</pre>";
	die("Execution halted");
}

?>
