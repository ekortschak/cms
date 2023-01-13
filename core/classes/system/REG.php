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

REG::add("css", "any.css");
REG::add("js", "any.js");

$arr = REG::get("js");

*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class REG {
	private static $dat = array();

public static function init() {}

// ***********************************************************
// handling single constants
// ***********************************************************
public static function add($key, $file) {
 // make sure file is only added once
	self::$dat[$key][$file] = $file;
}
public static function get($key) {
	return VEC::get(self::$dat, $key, false);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
