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
public static function replace($text, $search, $replace, $mod = "u") {
	$fnd = self::insert($search);
	return preg_replace("~$fnd~$mod", $replace, $text);
}
public static function replace1($text, $search, $replace, $mod = "u") {
	$fnd = self::insert($search);
	return preg_replace("~$fnd~$mod", $replace, $text, 1);
}
public static function clear($text, $what, $mod = "u") { // clear $what
	return self::replace($text, $what, "", $mod);
}

public static function clrDigits($text) { // clear leading digits followed by "."
	return preg_replace("~\b(\d+)\.~", "", $text);
}

public static function clrBlanks($text) { // whitespace
	return self::replace($text, "\s+", " ");
}

// ***********************************************************
public static function clrComments($text) {
	$out = preg_replace("~\/\*(.*?)\*\/~", "", $text); // multiline comments
	$out = preg_replace("~\/\/(.*?)\n~", "", $out); // lines starting at //
	$out = preg_replace("~#(.*?)\n~", "", $out); // lines starting at #
	return $out;
}

public static function clrTag($text, $tag) { // html tags and content
	return preg_replace("~<$tag(.*?)</$tag>~", "", $text);
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private static function insert($out) {
	$out = str_replace("@ANY", "(.*?)", $out);
	$out = str_replace("@NUM", "(\d+)", $out);
	return $out;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
