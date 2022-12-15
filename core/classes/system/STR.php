<?php
/* ***********************************************************
// INFO
// ***********************************************************
handling string tasks

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("system/STR.php");

$var = self::begins($haystack, $needle);

*/

if (function_exists("incCls"))
incCls("search/searchstring.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class STR {
	private static $sep = "¬¬¬";

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
public static function from($haystack, $needle) {
	$out = self::before($haystack, $needle);
	return $needle.$out;
}

public static function begins($haystack, $needle, $start = 0) {
	$out = self::simplify($haystack, $needle); if (! $needle) return false;
	$out = substr($out, $start, strlen(self::$sep));
	return ($out == self::$sep);
}

public static function matches($haystack, $needle) {
	$obj = new searchstring($haystack);
	return $obj->match($needle);
}

public static function misses($haystack, $needle) {
	return (! self::contains($haystack, $needle));
}
public static function contains($haystack, $needle) {
	if (! $needle) return false;
	$out = self::simplify($haystack, $needle);
	$pos = (strpos("@QWQ@.$out.", self::$sep));
	return ($pos > 0);
}

public static function ends($haystack, $needle) {
	$out = self::simplify($haystack, $needle); if (! $needle) return false;
	$out = substr($out, -strlen(self::$sep));
	return ($out == self::$sep);
}

public static function last($haystack, $needle) {
	$arr = VEC::explode($haystack, $needle);
	return end($arr);
}

public static function conv2utf8($string) {
	$arr = ['UTF-8', 'ASCII', 'ISO-8859-1'];

	foreach ($arr as $chs) {
		$chk = mb_detect_encoding($string, $arr);
		if ($chk == "UTF-8") return $string;
	}
	return mb_string_encoding($string, "UTF-8");
}

// ***********************************************************
// finding multiple sub strings
// ***********************************************************
public static function find($haystack, $sep1, $sep2) {
	$out = array(); // searches for distinct substrings between $sep1 and $sep2
	if (is_array($haystack)) return $haystack;
	if (! self::contains($haystack, $sep1)) return $out;
	if (! self::contains($haystack, $sep2)) return $out;

	$arr = explode($sep1, $haystack); unset($arr[0]);
	if (! $arr) return $out;

	foreach ($arr as $itm) {
		if (! $itm) continue; // drop anything after $sep2
		$key = self::before($itm, $sep2);
		$out[$key] = $key;
	}
	return $out;
}

// ***********************************************************
// finding sub strings
// ***********************************************************
public static function left($txt, $len = 3, $norm = true) {
	$txt = trim($txt);
	$txt = substr($txt, 0, $len); if ($norm)
	$txt = strtolower($txt);
	return $txt;
}
public static function right($txt, $len = 3, $norm = true) {
	return self::left($txt, $len * -1, $norm);
}

// ***********************************************************
public static function before($haystack, $sep = "\n", $trim = true) {
	$out = self::simplify($haystack, $sep).self::$sep;
	$pos = strpos($out, self::$sep);
	$out = substr($out, 0, $pos);
	return ($trim) ? trim($out) : $out;
}

public static function between($haystack, $sep1 = "(", $sep2 = ")", $trim = true) {
 // $sep2 expected to follow $sep1 before next $sep1
	$out = self::after($haystack, $sep1, false); if (! $out) return "";
	return self::before($out, $sep2, $trim);
}

// ***********************************************************
public static function afterAny($haystack, $sep = "\n", $trim = true) {
 //	find last $sep or return full string
	if ( ! self::contains($haystack, $sep)) return $haystack;
	$out = self::simplify($haystack, $sep).self::$sep;
	$out = explode(self::$sep, $out);
	$out = end($out);
	return ($trim) ? trim($out) : $out;
}

public static function after($haystack, $sep = "\n", $trim = true) {
 //	synonym for after1st
	return self::after1st($haystack, $sep, $trim);
}
public static function after1st($haystack, $sep = "\n", $trim = true) {
 //	find first $sep or return nothing
	if ($haystack == $sep) return "";
	if ( ! self::contains($haystack, $sep)) return false;
	$pos = self::findPos($haystack, $sep);
	$out = substr($haystack, current($pos) + strlen(key($pos)));
	return ($trim) ? trim($out) : $out;
}
public static function afterX($haystack, $sep = "\n", $trim = true) {
 //	find first $sep or return full string
	if ( ! self::contains($haystack, $sep)) return $haystack;
	return self::after1st($haystack, $sep, $trim);
}

public static function startingat($haystack, $needle) {
	$out = self::after($haystack, $needle); if (! $out) return false;
	return $needle.$out;
}

public static function hasSpecialChars($text, $lst = ".,;:!?()/\"'<>") {
	$lst = str_split($lst);
	return self::contains($text, $lst);
}

public static function beforeEOL($text, $lst = ".,;:!?") {
	$lst = str_split($lst);
	return self::before($text, $lst);
}

// ***********************************************************
// removing from string
// ***********************************************************
public static function clear($haystack, $substring) {
	return str_ireplace($substring, "", $haystack);
}

public static function clean($haystack, $sep1 = "(", $sep2 = ")") {
 // remove any text between pairs of $sep1 and $sep2
 // $sep2 expected to follow $sep1 before next $sep1
	$out = $haystack;
	$arr = self::find($out, $sep1, $sep2);

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
	$out = self::clear($code, "\r");

	$out = preg_replace("~ (\s*?)~", " ", $out);   // multiple blanks
	$out = self::replace($out, "\n ", "\n");        // leading blank
	$out = self::replace($out, " \n", "\n");        // trailing blank
	$out = self::replace($out, "_\n", "");          // join lines
	$out = preg_replace("~\n(\n*?)~", "\n", $out); // multiple line feeds

	if (self::ends($out, "_")) return trim($out, "_");
	return "$out\n";
}

// ***********************************************************
public static function pathify($out) {
	$out = self::replace($out, "Ä", "Ae");
	$out = self::replace($out, "ä", "ae");
	$out = self::replace($out, "Ö", "Oe");
	$out = self::replace($out, "ö", "oe");
	$out = self::replace($out, "Ü", "Ue");
	$out = self::replace($out, "ü", "ue");
	$out = self::replace($out, "ß", "ss");
	return $out;
}


// ***********************************************************
// replacing substrings
// ***********************************************************
public static function replace($haystack, $find, $rep) {
	return str_replace($find, $rep, $haystack);
}

public static function repFirst($haystack, $find, $rep) {
	$lft = self::before($haystack, $find);
	$rgt = self::after($haystack, $find);
	return ($rgt) ? $lft.$rep.$rgt : $lft;
}

public static function norm($key, $lowercase = false) {
	if (is_array($key)) $key = implode("//", $key);
	if ($lowercase) $key = strtolower($key);
	return trim($key);
}

// ***********************************************************
// hiliting substrings
// ***********************************************************
public static function markup($haystack, $from, $to) {
	$out = $haystack;
	$arr = self::find($out, $from, $to);

	foreach ($arr as $itm) {
		$out = str_replace($itm, "<markp>$itm</markp>", $out);
	}
	return $out;
}

public static function mark($haystack, $find) {
	$fnd = str_replace("|", " ", $find);

	$obj = new searchstring($haystack);
	$lst = $obj->split($fnd);
	$lst = VEC::sortByLen($lst);

	$out = $haystack; if (self::contains($out, "<mark")) return $out;
	$cnt = 0;

	foreach ($lst as $itm) {
		$idx = $cnt++ % 5 + 1;
		$out = self::markit($out, $itm, $idx);
	}
	return $out;
}
private static function markit($haystack, $find, $idx) {
	$lst = count(explode("^", $find));
	$rep = "<mark$idx>$1</mark$idx>";


	if ($lst > 2) $rep = "$1<mark>$2</mark>$3"; else
	if ($lst > 1) {
		if (self::ends($find, "^")) $rep = "<mark>$1</mark>$2";
		else $rep = "$1<mark>$2</mark>";
	}
	$fnd = preg_quote($find);
	$fnd = "($fnd)";
	$fnd = str_replace("(\^", "^(", $fnd);
	$fnd = str_replace("\^)", ")^", $fnd);
	$fnd = str_replace("^", "(\W+)", $fnd);

	$out = preg_replace("~$fnd~i", $rep, $haystack);
# TODO: no marking in html-tags
#	$out = preg_replace("~<(.*?)$fnd(.*?)>~i",  "<$1$2>",  $haystack);
#	$out = preg_replace("~</(.*?)$fnd(.*?)>~i", "</$1$2>", $haystack);
	return $out;
}

// ***********************************************************
// search strings
// ***********************************************************
public static function split($haystack, $sep1, $sep2 = "") {
	$del = "@|@";
	$txt = str_replace($sep1, $del.$sep1, $haystack);
	$arr = explode($del, $txt); if (! $sep2) return $arr;
	$out = array();

	foreach ($arr as $val) {
		if (self::contains($val, $sep2))
		$val = self::before($val, $sep2).$sep2;
		$out[] = $val;
	}
	return $out;
}

public static function toArray($what, $seps = "std") {
 // turns a string with various common separators into an array
	switch ($seps) {
		case "std": $seps = ".,; \n"; break;
		case "ref": $seps = ";|\n"; break;
	}
	$del = self::$sep;
	$sep = str_split($seps);
	$txt = str_replace($sep, $del, $what);
	$arr = explode($del, $txt);
	$out = array();

	foreach ($arr as $val) {
		$val = trim($val); if (! $val) continue;
		$out[$val] = $val;
	}
	return $out;
}

public static function toAssoc($what, $seps = "ref") {
	$arr = self::toArray($what, $seps);
	if ( ! self::contains($what, ":=")) return array_combine($arr, $arr);
	$out = array();

	foreach ($arr as $val) {
		$key = self::before($val, ":="); if (! $key) continue;
		$val = self::after($val, ":=");
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
	$out = self::clear($val, $sep);
	$out = str_replace($com, ".", $out);
	if (! is_numeric($out)) return 0;
	return $out;
}

public static function dec($val) {
	return number_format($val, 0, ",", ".");
}
public static function int($val) {
	return intval($val);
}

public static function maskPwd($pwd) {
	if (strlen($pwd) == 32) return $pwd;
	return md5($pwd);
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private static function simplify($txt, $sep) {
	if (! is_array($sep)) $sep = array($sep);

	foreach ($sep as $del) { // delimiter
		$txt = str_ireplace($del, self::$sep, $txt);
	}
	return $txt;
}

public static function findPos($haystack, $sep) {
	if (! is_array($sep)) $sep = array($sep); $out = array();

	foreach ($sep as $del) { // find matching strings
		$pos = stripos($haystack, $del); if ($pos === false) continue;
		$out[$del] = $pos; // store position in string
	}
	asort($out); return $out;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>