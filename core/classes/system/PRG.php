<?php
/* ***********************************************************
// INFO
// ***********************************************************
handling string tasks with preg functions

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("system/prg.php");

*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class PRG {

public static function quote($find) {
	$out = preg_quote($find);
	return PRG::xlate($out);
}

// ***********************************************************
// match strings
// ***********************************************************
public static function find($haystack, $needle, $mod = "u") {
	$out = array(); if (STR::contains($needle, "\n")) $mod.= "g";
	$res = preg_match_all("~$needle~$mod", $haystack, $out);
	return $out[0];
}

// ***********************************************************
// replace strings
// ***********************************************************
public static function replace($text, $search, $replace, $mod = "u") {
	$fnd = PRG::xlate($search);
	return preg_replace("~$fnd~$mod", $replace, $text);
}
public static function repFirst($text, $search, $replace, $mod = "u") {
	$fnd = PRG::xlate($search); // replace first occurrence only
	return preg_replace("~$fnd~$mod", $replace, $text, 1);
}

public static function clrBlanks($text) { // whitespace
	return PRG::replace($text, "\s+", " ");
}

// ***********************************************************
// clear string of whatsoever
// ***********************************************************
public static function clear($text, $what, $mod = "u") {
	return PRG::replace($text, $what, "", $mod);
}

public static function clrTag($text, $tag) { // html tags and content
	return PRG::clear($text, "<$tag(.*?)</$tag>");
}

public static function clrDigits($text) { // clear leading digits followed by "."
	return PRG::clear($text, "\b(\d+)\.");
}

public static function clrComments($text) {
	$lst = "/*@ANY*/@LF|//@ANY@LF|#@ANY@LF";
	$arr = STR::split($lst, "|");

	foreach ($arr as $itm) {
		$fnd = PRG::quote($itm);
		$out = PRG::clear($text, $itm, "");
	}
	return $out;
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private static function xlate($out) {
	$out = str_replace("@ANY", "(.*?)", $out);
	$out = str_replace("@NUM", "(\d+)", $out);
	$out = str_replace("@CHR", "([a-zA-Z]+)", $out);
	$out = str_replace("@LF",  "(\n?)", $out);
	return $out;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
