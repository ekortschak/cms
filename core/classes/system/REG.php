<?php
/* ***********************************************************
// INFO
// ***********************************************************
contains static functions for handling
* script & css registration

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("system/REG.php");

REG::add("path/to/any.css");
REG::add("path/to/any.js");

$arr = REG::get("js");

*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class REG {
	private static $dat = array();

// ***********************************************************
// handling single constants
// ***********************************************************
public static function add($file) {
	$ext = strtolower(FSO::ext($file));
	$fil = CFG::apply($file);

 // make sure file is only added once
	REG::$dat[$ext][$file] = $fil;
}
public static function get($ext) {
	return VEC::get(REG::$dat, $ext, false);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
