<?php
/* ***********************************************************
// INFO
// ***********************************************************
handling string tasks

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("system/STR.php");

$var = STR::begins($haystack, $needle);

*/

if (function_exists("incCls"))
incCls("search/sString.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class STR {
	const SEP = "¬¬¬";
	const LIM = "@|@";

// ***********************************************************
// concat
// ***********************************************************
public static function join() {
	$arr = func_get_args();
	return implode(".", $arr);
}

// ***********************************************************
// checking string content
// ***********************************************************
public static function begins($haystack, $needle, $start = 0) {
	$out = STR::simplify($haystack, $needle); if (! $needle) return false;
	$out = substr($out, $start, strlen(STR::SEP));
	return ($out == STR::SEP);
}
public static function ends($haystack, $needle) {
	$out = STR::simplify($haystack, $needle); if (! $needle) return false;
	$out = substr($out, -strlen(STR::SEP));
	return ($out == STR::SEP);
}

// ***********************************************************
public static function features($haystack, $needle) {
	return (STR::contains(".$haystack.", ".$needle."));
}
public static function misses($haystack, $needle) {
	return (! STR::contains($haystack, $needle));
}
public static function contains($haystack, $needle) {
	if (! $needle) return false;
	$out = STR::simplify($haystack, $needle);
	$pos = strpos(STR::LIM.$out, STR::SEP);
	return ($pos > 0);
}

public static function matches($haystack, $needle) {
	$obj = new sString($haystack);
	return $obj->match($needle);
}

// ***********************************************************
public static function hasSpecialChars($text, $lst = ".,;:!?()/\"'<>") {
	$lst = str_split($lst);
	return STR::contains($text, $lst);
}

// ***********************************************************
// finding multiple sub strings
// ***********************************************************
public static function find($haystack, $sep1, $sep2, $trim = true) {
	$out = array(); // searches for distinct substrings between $sep1 and $sep2
	if (is_array($haystack)) return $haystack;
	if (STR::misses($haystack, $sep1)) return $out;
	if (STR::misses($haystack, $sep2)) return $out;

	$arr = explode($sep1, $haystack); unset($arr[0]);
	if (! $arr) return $out;

	foreach ($arr as $itm) {
		if (! $itm) continue; // drop anything after $sep2
		$key = STR::before($itm, $sep2, $trim);
		$out[$key] = $key;
	}
	return $out;
}

// ***********************************************************
// finding sub strings
// ***********************************************************
public static function from($haystack, $needle) {
	$out = STR::after($haystack, $needle); if (! $out) return false;
	return $needle.$out;
}

public static function left($text, $len = 3, $norm = true) {
	$txt = trim($text);
	$txt = substr($txt, 0, $len); if ($norm)
	$txt = strtolower($txt);
	return $txt;
}
public static function right($text, $len = 3, $norm = true) {
	return STR::left($text, $len * -1, $norm);
}

public static function count($haystack, $needle) {
	return substr_count($haystack, $needle);
}

public static function trunc($text, $size = 50) {
	if (! $text) return "-";
	if (strlen($text) <= $size) return $text;
	return substr($text, 0, $size)." ...";
}

public static function camel($text) {
	$arr = STR::split($text, " "); $out = "";

	foreach ($arr as $itm) {
		$out.= ucFirst($itm);
	}
	return $out;
}

// ***********************************************************
public static function beforePunct($haystack) {
	$out = STR::toArray($haystack, "pnc");
	return current($out);
}

public static function before($haystack, $sep = "\n", $trim = true) {
	$out = STR::simplify($haystack, $sep);

	$out.= STR::SEP; $pos = strpos($out, STR::SEP);
	$out = substr($out, 0, $pos);
	return ($trim) ? trim($out) : $out;
}

public static function between($haystack, $sep1 = "(", $sep2 = ")", $trim = true) {
 // $sep2 expected to follow $sep1 before next $sep1
	$out = STR::after($haystack, $sep1, false); if (! $out) return "";
	return STR::before($out, $sep2, $trim);
}

// ***********************************************************
public static function afterLast($haystack, $needle = "\n", $trim = true) {
 //	find last $needle or return full string
	if ( STR::misses($haystack, $needle)) return $haystack;
	$out = STR::simplify($haystack, $needle);
	$out = explode(STR::$needle, $out);
	$out = end($out);
	return ($trim) ? trim($out) : $out;
}

public static function after($haystack, $needle = "\n", $trim = true) {
 //	find first $needle or return nothing
	if ($haystack == $needle) return "";
	if ( STR::misses($haystack, $needle)) return false;
	$pos = STR::findPos( $haystack, $needle);
	$out = substr($haystack, current($pos) + strlen(key($pos)));
	return ($trim) ? trim($out) : $out;
}
public static function afterX($haystack, $needle = "\n", $trim = true) {
 //	find first $needle or return full string
	$out = STR::after($haystack, $needle, $trim);
	return ($out) ? $out : $haystack;
}

// ***********************************************************
// cleaning strings
// ***********************************************************
public static function clear($haystack, $substring) {
	return STR::replace($haystack, $substring, "", false);
}

public static function clean($haystack, $sep1 = "(", $sep2 = ")") {
 // remove any text between pairs of $sep1 and $sep2
 // $sep2 expected to follow $sep1 before next $sep1
	$out = $haystack;
	$arr = STR::find($out, $sep1, $sep2);

	foreach ($arr as $val) {
		$out = str_replace("$sep1$val$sep2", "", $out);
	}
	return $out;
}

// ***********************************************************
public static function dropComments($code) {
	$out = "$code\n";
    $out = str_replace("\#", "<hashtag>", $out); // protect # (no comment)
    $out = preg_replace("~#(.*?)\n~", "\n", $out); // remove comments
    $out = str_replace("<hashtag>", "#", $out);

    return trim($out);
}

// ***********************************************************
public static function dropSpaces($code) {
	$out = STR::trim($code, "_");
	$out = STR::clear($out, "\r");
	$out = STR::replace($out, "_\n", "");    // join lines
	$out = STR::replace($out, "\t ", " ");
	$out = STR::limChar($out, " ");

	$out = STR::replace($out, "\n ", "\n");  // leading blank
	$out = STR::replace($out, " \n", "\n");  // trailing blank
	$out = STR::limChar($out, "\n", 3);
	return $out;
}

public static function limChar($code, $chr, $cnt = 1) { // limit char repetition
	$rep = str_repeat($chr, $cnt);
	return preg_replace("~$rep($chr+)~", $rep, $code);
}

public static function trim($text, $chars = "") {
	return trim($text, " \n\r\t\v\x00".$chars);
}

// ***********************************************************
// replacing substrings
// ***********************************************************
public static function replace($haystack, $find, $rep = "", $case = true) {
	if ($case) // case sensitive
	return str_replace ($find, $rep, $haystack);
	return str_ireplace($find, $rep, $haystack);
}

public static function repFirst($haystack, $find, $rep) {
	$lft = STR::before($haystack, $find);
	$rgt = STR::after($haystack, $find);
	return ($rgt) ? $lft.$rep.$rgt : $lft;
}

public static function norm($key, $lowercase = false) {
	if (is_array($key)) $key = implode("//", $key);
	if ($lowercase) $key = strtolower($key);
	return trim($key);
}

// ***********************************************************
// bracketing
// ***********************************************************
public static function quote($haystack, $bracket = '"') {
	return $bracket.$haystack.$bracket;
}

// ***********************************************************
// hiliting substrings
// ***********************************************************
public static function markup($haystack, $from, $to) {
	$out = $haystack;
	$arr = STR::find($out, $from, $to);

	foreach ($arr as $itm) {
		$out = str_replace($itm, "<markp>$itm</markp>", $out);
	}
	return $out;
}

public static function mark($haystack, $find) {
	$obj = new sString($haystack);
	return $obj->hilite($find);
}

// ***********************************************************
// search strings
// ***********************************************************
public static function splitAt($haystack, $sep) { // retains $sep as part of result
	$txt = str_replace($sep, STR::SEP.$sep, $haystack);
	return explode(STR::SEP, $txt);
}

public static function split($haystack, $sep = "\n", $trim = true) { // removes $sep from result
	$out = explode($sep, $haystack);

	foreach ($out as $key => $val) {
		if ($trim) $val = trim($val);
		$out[$key] = $val;
	}
	return $out;
}

public static function toArray($text, $seps = "std") {
 // turns a string with various common separators into an array
	switch ($seps) {
		case "pnc": $seps = ".,;:/\n()"; break;
		case "std": $seps = ".,;: \n()"; break;
		case "ref": $seps = ";|\n"; break;
	}
	$sep = str_split($seps);
	$txt = str_replace($sep, STR::SEP, $text);
	$arr = explode(STR::SEP, $txt);
	$out = array();

	foreach ($arr as $val) {
		$val = trim($val); if (! $val) continue;
		$out[$val] = $val;
	}
	return $out;
}

public static function toAssoc($text, $seps = "ref") {
	$arr = STR::toArray($text, $seps);
	if ( STR::misses($text, ":=")) return array_combine($arr, $arr);
	$out = array();

	foreach ($arr as $val) {
		$key = STR::before($val, ":="); if (! $key) continue;
		$val = STR::after($val, ":=");
		$out[$key] = $val;
	}
	return $out;
}

// ***********************************************************
// formatting methods
// ***********************************************************
public static function toNumber($val, $fmt = "de") {
	if ($val == "") return 0;
	$val = str_replace(" ", "", $val);

	switch ($fmt) {
		case "de": $sep = "."; $com = ","; break;
		default:   $sep = ","; $com = ".";
	}
	$out = STR::clear($val, $sep);
	$out = str_replace($com, ".", $out);
	if (! is_numeric($out)) return 0;
	return $out;
}

public static function toDec($val) {
	return number_format($val, 0, ",", ".");
}
public static function toInt($val) {
	return intval($val);
}

public static function maskPwd($pwd) {
	if (strlen($pwd) == 32) return $pwd;
	return md5($pwd);
}

// ***********************************************************
// handling utf8
// ***********************************************************
public static function conv2utf8($string) {
	$arr = ['UTF-8', 'ASCII', 'ISO-8859-1'];

	foreach ($arr as $chs) {
		$chk = mb_detect_encoding($string, $arr);
		if ($chk == "UTF-8") return $string;
	}
	return mb_string_encoding($string, "UTF-8");
}

public static function utf8decode($string) {
	$out = utf8_decode($string);
	return STR::afterX($out, "?"); // because of utf8_decode();
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private static function simplify($txt, $sep) {
	if (! $txt) return "";
	if (! is_array($sep)) $sep = array($sep);

	foreach ($sep as $del) { // delimiter
		$txt = str_ireplace($del, STR::SEP, $txt);
	}
	return $txt;
}

public static function findPos($haystack, $sep) {
	if (! is_array($sep)) $sep = array($sep); $out = array();

	foreach ($sep as $del) { // find matching strings
		$pos = stripos($haystack, $del); if ($pos === false) continue;
		$out[$del] = $pos; // store position in string
	}
	return VEC::sort($out, "asort"); // first occurrance first
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
