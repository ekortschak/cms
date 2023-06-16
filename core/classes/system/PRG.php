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
	return preg_quote($find);
}

// ***********************************************************
public static function find($haystack, $needle, $mod = "u") {
	$out = array(); if (STR::contains($needle, "\n")) $mod.= "g";
	$erg = preg_match_all("~$needle~$mod", $haystack, $out);
	return $out[0];
}

// ***********************************************************
// replace strings
// ***********************************************************
public static function replace($text, $search, $replace, $mod = "u") {
	$fnd = self::xlate($search);
	return preg_replace("~$fnd~$mod", $replace, $text);
}
public static function replace1($text, $search, $replace, $mod = "u") {
	$fnd = self::xlate($search); // replace first occurrence only
	return preg_replace("~$fnd~$mod", $replace, $text, 1);
}

public static function clrBlanks($text) { // whitespace
	return self::replace($text, "\s+", " ");
}

// ***********************************************************
// clear string of whatsoever
// ***********************************************************
public static function clear($text, $what, $mod = "u") {
	return self::replace($text, $what, "", $mod);
}

public static function clrTag($text, $tag) { // html tags and content
	return self::clear($text, "<$tag(.*?)</$tag>");
}

public static function clrDiv($text, $tag) { // html divs and content
	return self::clear($text, "<div class=\"$tag\"(.*?)</div>");
}

public static function clrDigits($text) { // clear leading digits followed by "."
	return self::clear($text, "\b(\d+)\.");
}

public static function clrComments($text) {
	$out = self::clear($text, "\/\*(.*?)\*\/"); // multiline comments
	$out = self::clear($text, "\/\/(.*?)\n"); // lines starting at //
	$out = self::clear($text, "#(.*?)\n"); // lines starting at #
	return $out;
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private static function xlate($out) {
	$out = str_replace("@ANY", "(.*?)", $out);
	$out = str_replace("@NUM", "(\d+)", $out);
	return $out;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
