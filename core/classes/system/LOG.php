<?php
/* ***********************************************************
// INFO
// ***********************************************************
- intended to handle message logging

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("system/LOG.php");

*/

LOG::init();

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class LOG {
	private static $drt = "dirty.inf";


public static function init() {
	$dir = LOG::dir(APP_NAME);
	FSO::rmFiles($dir, "*.log");
}

// ***********************************************************
public static function dir($app = "") {
	return FSO::join(TOP_DIR, "cms.log", $app);
}
public static function file($file, $app = APP_NAME) {
	$dir = LOG::dir($app);
	return FSO::join($dir, $file);
}

// ***********************************************************
// writing files
// ***********************************************************
public static function log($data) {
	LOG::write("run.log", $data);
}

public static function write($file, $data, $mode = FILE_APPEND) {
	$fil = LOG::file($file);
	$xxx = APP::write($fil, $data, $mode);
}

// ***********************************************************
// logging vars
// ***********************************************************
public static function set($key, $val) {
	SSV::set($key, $val, "log");
}
public static function get($key, $default = false) {
	return SSV::get($key, $default, "log");
}

// ***********************************************************
// mark modified projects
// ***********************************************************
public static function dirty($app) {
	$fil = LOG::file(LOG::$drt, $app);
	$xxx = FSO::force(dirname($fil));
	$txt = APP::read($fil);
	$txt = STR::replace($txt, "= 1", "= 0");
	$ret = file_put_contents($fil, $txt);
	$xxx = FSO::permit($fil);
}
public static function isDirty($app, $agent) {
	$fil = LOG::file(LOG::$drt, $app); if (! is_file($fil)) return false;
	$txt = APP::read($fil);	           if (! $txt) return true;
	return STR::misses($txt, "$agent = 1");
}

public static function clear($app, $agent) { // project has been synched
	$fil = LOG::file(LOG::$drt, $app); if (! is_file($fil)) return;
	$txt = APP::read($fil);

	switch (STR::contains($txt, "$agent =")) {
		case true: $txt = STR::replace($txt, "$agent = 0", "$agent = 1"); break;
		default:   $txt.= "$agent = 1";
	}
	APP::write($fil, $txt);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
