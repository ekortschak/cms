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
	private static $arc = "/var/www/cms.archive";

public static function init() {
	$sec = "remote"; if (IS_LOCAL) $sec = "local";

	LOC::$arc = CFG::getVal("backup:$sec.archive", LOC::$arc);
	LOC::setArchive(LOC::$arc);
}

public static function setArchive($dir) {
	LOC::$arc = FSO::join($dir, "cms.archive");
}

// ***********************************************************
// app dirs or files
// ***********************************************************
public static function tempDir($dir = "temp", $sub = "") { // always local dirs
	return LOC::arcDir(LOC::$arc, $dir, $sub);
}

public static function arcDir($dir = "", $sub = "") { // archive
	return FSO::join(LOC::$arc, APP_NAME, $dir, $sub);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
