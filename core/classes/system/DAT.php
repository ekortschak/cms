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
	private static $min_year = 2000;
	private static $max_year = 2100;

	const DAY_SECS = 86400;

// ***********************************************************
public static function make($year, $mon, $day) {
	return DAT::get("$year/$mon/$day");
}

// ***********************************************************
public static function years($coming = 1, $past = 5) {
	$cur = date("Y");
	$max = CHK::range($coming, 5); DAT::$max_year = $cur + $max;
	$min = CHK::range($past,   7); DAT::$min_year = $cur - $min;

	return VEC::range(DAT::$max_year, DAT::$min_year);
}
public static function months() {
	return VEC::range(1, 12);
}
public static function numDays($year, $mon) {
	$dat = DAT::toSecs("$year/$mon/1");
	$lst = date("t", $dat);
	return VEC::range(1, $lst);
}

// ***********************************************************
public static function checkMax($date) {
	$max = DAT::make(DAT::$max_year, 12, 31);
	return DAT::isPrior($date, $max);
}
public static function checkMin($date) {
	$min = DAT::make(DAT::$min_year, 1, 1);
	return DAT::isLater($date, $min);
}

// ***********************************************************
private static function chkYear($year) {
	$cur = date("Y"); if (! $year) return $cur;
	return CHK::range($year, 2000, $cur + 25);
}

private static function chkMonth($mon) {
	$cur = date("m"); if (! $mon) return $cur;
	return CHK::range($mon, 1, 12);
}

// ***********************************************************
// comparing dates
// ***********************************************************
public static function prior($date, $comp) {
 // returns earlier of $date and $comp
	$one = DAT::toSecs($date); if (! $one) return $comp;
	$two = DAT::toSecs($comp); if ($one < $two) return $date;
	return $comp;
}

public static function later($date, $comp) {
 // returns later of $date and $comp
	return DAT::earlier($comp, $date);
}
public static function isprior($date, $comp) {
 // returns true if $date preceeds $comp
	return (DAT::prior($date, $comp) == $date);
}
public static function islater($date, $comp) {
 // returns true if $date is past $comp
	return DAT::isprior($comp, $date);
}

// ***********************************************************
// calculating dates
// ***********************************************************
public static function now($offset = 0, $format = DATE_FMT) {
 // $offset = number of days from now, e.g. +7, 7 or -7
	return DAT::addDays(time(), $offset, $format);
}
public static function calc($date, $offset = 1, $format = DATE_FMT) {
	return DAT::addDays($date, $offset, $format);
}

// ***********************************************************
private static function addDays($timestamp, $offset, $format = DATE_FMT) {
	$ofs = $offset * DAT::DAY_SECS;
	$out = $timestamp + $ofs; if (! $format) return $out;
	return date($format, $out);
}

public static function difDays($first, $second) {
 // returns number of days between $first and $second
	$one = DAT::toSecs($first);
	$two = DAT::toSecs($second);
	return intval(($one - $two) / DAT::DAY_SECS);
}

// ***********************************************************
public static function next($what = "Monday") {
	return DAT::find("next week $what");
}
public static function last($what = "Monday") {
	return DAT::find("last week $what");
}
public static function first($what = "Monday", $mon = false, $year = false) {
	$yir = DAT::chkYear($year);
	$mon = DAT::chkMonth($mon);
	return DAT::find("first $what $yir-$mon");
}

// ***********************************************************
public static function firstOfMonth($date) {
	$yir = DAT::get($date, "Y");
	$mon = DAT::get($date, "m");
	return DAT::make($yir, $mon, 1);
}

public static function lastOfMonth($date) {
	$dat = DAT::toSecs($date);
	return date("t", $dat);
}

// ***********************************************************
public static function firstOfWeek($date) {
	$wkd = DAT::weekday($date);
	return DAT::calc($date, $wkd * -1 + 1);
}

public static function lastOfWeek($date) {
	$dat = DAT::firstOfWeek($date);
	return DAT::calc($dat, 6);
}

// ***********************************************************
private static function find($what) {
	$out = strtotime($what);
	return DAT::get($out);
}

public static function weekday($date) {
	$wkd = DAT::get($date, "w");
	return ($wkd == 0) ? 7 : $wkd;
}

// ***********************************************************
// conversions
// ***********************************************************
public static function split($date) {
	return array(
		"y" => intval(DAT::get($date, "Y")),
		"m" => intval(DAT::get($date, "m")),
		"d" => intval(DAT::get($date, "d")),
		"h" => intval(DAT::get($date, "H")),
		"n" => intval(DAT::get($date, "n")),

		"w" => DAT::weekday($date),
	);
}

public static function get($date = false, $format = DATE_FMT) {
	$dat = $date; if (! $dat) return date($format);
	$dat = DAT::toSecs($dat);
	return date($format, $dat);
}
public static function long($date) { return DAT::get($date, DATE_FMT." H:i"); }
public static function date($date) { return DAT::get($date, DATE_FMT); }
public static function time($date) { return DAT::get($date, "H:i"); }

public static function toSecs($string) { // return time stamp
	$dat = DAT::strip($string); if (! $dat) return false;
	if (is_numeric($dat)) return $dat;

	$dat = str_replace(".", "/", $dat);
	$dat = str_replace("-", "/", $dat);
	return strtotime($dat);
}

public static function getDay($date, $mode = "short") {
	$mod = ""; if ($mode == "long") $mod = ".l";

	$wkd = DAT::weekday($date);
	return DIC::get("day.$wkd$mod");
}

public static function getMonth($date, $mode = "short") {
	$mod = ""; if ($mode == "long") $mod = ".l";
	$mon = DAT::get($date, "m"); $mon = intval($mon);
	return DIC::get("mon.$mon$mod");
}

// ***********************************************************
// sorting data
// ***********************************************************
public static function sort($arr, $key, $sort = "asc") {
	$tmp = $out = array();

	foreach ($arr as $key => $rec) {
		$crt = VEC::get($rec, $key); if (! $crt) continue;
		$crt = DAT::strip($crt);
		$crt = DAT::ymd($crt);

		$tmp[$crt][$key] = $rec;
	}
	switch ($sort) {
		case "asc":  $tmp = VEC::sort($tmp, "ksort");  break;
		case "desc": $tmp = VEC::sort($tmp, "krsort"); break;
	}
	foreach ($tmp as $dat => $rec) {
		$rec = VEC::sort($rec);

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
