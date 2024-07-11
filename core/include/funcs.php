<?php

// ***********************************************************
// find files or default to fallback dir
// ***********************************************************
function incCls($file, $dir = LOC_CLS) {
#	$fil = SYS::file("$dir/$file"); # TODO: why not working on server
	$fil = $file; if (! is_file($file))
	$fil = appFile("$dir/$file");
	include_once $fil;
}
function appFile($file) {
	$out = APP_DIR."/$file"; if (is_file($out)) return $out;
	$out = FBK_DIR."/$file"; if (is_file($out)) return $out;
	return $file;
}

// ***********************************************************
// error handling
// ***********************************************************
function errMode($mode = ERR_SHOW) {
	$mod = (int) (bool) $mode;

	switch ($mod) {
		case true: error_reporting(E_ALL); break;
		default:   error_reporting(0);
	}
	ini_set("display_startup_errors", $mod);
	ini_set("display_errors", $mod);
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

function dbgpi($path = "hier", $info = "dbg") { // show path info
	dbg(CFG::encode($path), $info);
}

function dbx($msg, $info = "aborting") {
	dbg($msg, $info);
	die("<hr>Execution halted by dbx()<hr>");
}

?>
