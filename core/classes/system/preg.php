<?php
/* ***********************************************************
// INFO
// ***********************************************************
handling string tasks with preg functions

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("system/preg.php");

*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class PRG {

public static function quote($find) {
	return preg_quote($find);
}

private static function insert($out) {
	$out = STR::replace($out, "@ANY", "(.*?)");
	$out = STR::replace($out, "@NUM", "(\d+)");
	return $out;
}


public static function replace($text, $search, $replace, $mod = "") {
	$fnd = self::insert($search);
	return preg_replace("~$fnd~$mod", $replace, $text);
}

public static function replaceWords($text, $search, $mask, $mod = "") {
	$rep = STR::replace($mask, $search, "\$1\$2\$3");

	switch (CUR_LANG) {
		case "de": $fnd = "\b($search)([e]?)([snmr]?)\b"; break;
		default:   $fnd = "\b($search)([s]?)\b"; break;
	}
	return preg_replace("~$fnd~$mod", $rep, $text);
}

public static function clear($text, $what) { // clear $what
	$what = self::quote($what);
	return preg_replace("~$what~", "", $text);
}

public static function clrDigits($text) { // clear leading digits followed by "."
	return preg_replace("~(\d+)\.~", "", $text);
}

public static function clrComments($text) {
	$out = preg_replace("~\/\*(.*?)\*\/~", "", $text); // blocks
	$out = preg_replace("~\/\/(.*?)\n~", "", $out); // lines starting at //
	$out = preg_replace("~#(.*?)\n~", "", $out); // lines starting at #
	return $out;
}

public static function clrBlanks($text) { // whitespace
	return preg_replace("~\s+~", " ", $text);
}

public static function clrTag($text, $tag) { // html tags and content
	return preg_replace("~<$tag(.*?)</$tag>~", "", $text);
}

public static function find($haystack, $needle) {
	$out = array();
	$fnd = self::quote($needle);
	$erg = preg_match_all("~$fnd~", $haystack, $out);
	return $out[0];
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
