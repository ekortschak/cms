<?php
/* ***********************************************************
// INFO
// ***********************************************************
- contains methods concerning special paths

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("system/LOC.php");

LOC::setArchive($dir);

$arc = LOC::arcDir($dir, $sub);

*/

LOC::init();

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class LOC {
	private static $app = APP_NAME;
	private static $arc = "/var/www/cms.archive";

	private const MY_ARC = "cms.archive";

public static function init() {
	$top = dirname(TOP_DIR);
	$dir = FSO::join($top, self::MY_ARC);
	LOC::setArchive($dir);
}

public static function setArchive($dir) {
	LOC::$arc = FSO::join($dir, self::MY_ARC);
}

// ***********************************************************
// app dirs or files
// ***********************************************************
public static function tempDir($dir = "temp", $sub = "") { // always local dirs
	return LOC::arcDir($dir, $sub);
}

public static function arcDir($app = APP_NAME, $dir = "", $sub = "") { // archive
	return FSO::join(LOC::$arc, $app, $dir, $sub);
}

public static function dir($dir) {
	if (! STR::begins($dir, LOC::$arc)) return $dir;
	$out = STR::after($dir, LOC::$arc);
	return FSO::join("ARC_DIR", $out);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
