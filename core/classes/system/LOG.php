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
	self::$dir = APP::tempDir("log");
	FSO::rmFiles(self::$dir);
}

public static function file($file) {
	return FSO::join(self::$dir, $file);
}

// ***********************************************************
public static function write($file, $data, $mode = FILE_APPEND) {
	if (! IS_LOCAL) return;
	
	$fil = FSO::join(self::$dir, $file);
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
