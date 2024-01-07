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
	private static $dir = false;

public static function init() {
	LOG::$dir = FSO::join(APP_ROOT, "_log", APP_NAME);
	FSO::rmFiles(LOG::$dir);
}

public static function file($file) {
	return FSO::join(LOG::$dir, $file);
}

// ***********************************************************
public static function log($data) {
	LOG::write("run.log", $data);
}

public static function write($file, $data, $mode = FILE_APPEND) {
	$fil = FSO::join(LOG::$dir, $file);
	$xxx = APP::write($fil, $data, $mode);
}

// ***********************************************************
public static function set($key, $val) {
	SSV::set($key, $val, "log");
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
