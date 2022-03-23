<?php
/* ***********************************************************
// INFO
// ***********************************************************
handling date tasks

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("system/DAT.php");

*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class DAT {

// ***********************************************************
// comparing dates
// ***********************************************************
public static function later($stat, $comp) { // $stat = date to compare to
 // returns later of $stat and $comp
	$one = self::strip($stat); if (! $one) return $comp;
	$two = self::strip($comp);

	$one = self::toSecs($one);
	$two = self::toSecs($two); if ($one > $two) return $stat;
	return $comp;
}
public static function earlier($stat, $comp) { // $stat = date to compare to
 // returns earlier of $stat and $comp
	$one = self::strip($stat); if (! $one) return $comp;
	$two = self::strip($comp);

	$one = self::toSecs($one);
	$two = self::toSecs($two); if ($one < $two) return $stat;
	return $comp;
}

public static function before($stat, $comp) { // $stat = date to compare to
 // returns true if $stat preceeds $comp
	$out = self::earlier($stat, $comp);
	return ($out == $comp);
}
public static function after($stat, $comp) { // $stat = date to compare to
 // returns true if $stat is past $comp
	$out = self::later($stat, $comp);
	return ($out == $comp);
}

// ***********************************************************
// calculating with dates
// ***********************************************************
public static function now($offset = 0, $format = DATE_FMT) {
 // $offset = number of days from now, e.g. +7, 7 or -7
	$out = time() + $offset * 24 * 60 * 60; if (! $format) return $out;
	return date($format, $out);
}

public static function days($first, $second) {
 // returns number of days between $first and $second
	$one = self::toSecs($first);
	$two = self::toSecs($second);
	return intval(($one - $two) / 86400);
}

public static function next($what = "Monday") {
	return self::Ymd(strtotime("next week $what"));
}
public static function last($what = "Monday") {
	return self::Ymd(strtotime("last week $what"));
}
public static function first($what = "Monday", $mon = NV, $jahr = NV) {
	if ($jahr == NV) $jahr = date("Y");
	if ($mon  == NV) $mon  = date("m");
	return self::Ymd(strtotime("first $what $jahr-$mon"));
}

// ***********************************************************
// conversions
// ***********************************************************
public static function get($date, $format = DATE_FMT) {
	$dat = self::toSecs($date); if (! $dat) return "";
	return date($format, $dat);
}
public static function Ymd($date)     { return self::get($date); }
public static function YmdTime($date) {	return self::get($date, DATE_FMT." H:i"); }
public static function Time($date)    { return self::get($date, "H:i"); }

public static function toSecs($string) { // return time stamp
	if (is_numeric($string)) return $string;

	$dat = strip_tags($string); if (! $dat) return 0;
	$dat = strtotime($dat); if ($dat) return $dat;

	$dat = str_replace(".", "/", $string);
	$dat = strtotime($dat); if ($dat) return $dat;

	$dat = str_replace("/", ".", $string);
	$dat = strtotime($dat); if ($dat) return $dat;
	return false;
}

// ***********************************************************
// sorting data
// ***********************************************************
public static function sort($arr, $key, $sort = "asc") {
	$tmp = $out = array();

	foreach ($arr as $key => $rec) {
		$crt = VEC::get($rec, $key); if (! $crt) continue;
		$crt = strip_tags($crt);
		$crt = self::Ymd($crt);

		$tmp[$crt][$key] = $rec;
	}
	switch ($sort) {
		case "asc":  ksort( $tmp); break;
		case "desc": krsort($tmp); break;
	}
	foreach ($tmp as $dat => $rec) {
		ksort($rec);

		foreach ($rec as $key => $inf) {
			$out[$key] = $inf;
		}
	}
	return $out;
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private static function strip($val) {
	return trim(strip_tags($val));
}
// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
