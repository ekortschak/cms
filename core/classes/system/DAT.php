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
	private static $lenDay = 86400;
	private static $minYear = 2000;
	private static $maxYear = 2100;

// ***********************************************************
public static function make($year, $mon, $day) {
	return self::get("$year/$mon/$day");
}

// ***********************************************************
public static function years($coming = 1, $past = 5) {
	$cur = date("Y");
	$max = CHK::range($coming, 0, 5); self::$maxYear = $cur + $max;
	$min = CHK::range($past,   0, 7); self::$minYear = $cur - $min;

	return VEC::range(self::$maxYear, self::$minYear);
}
public static function months() {
	return VEC::range(1, 12);
}
public static function numDays($year, $mon) {
	$dat = self::toSecs("$year/$mon/1");
	$lst = date("t", $dat);
	return VEC::range(1, $lst);
}

// ***********************************************************
public static function checkMax($date) {
	$max = self::make(self::$maxYear, 12, 31);
	return self::isPrior($date, $max);
}
public static function checkMin($date) {
	$min = self::make(self::$minYear, 1, 1);
	return self::isLater($date, $min);
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
	$one = self::toSecs($date); if (! $one) return $comp;
	$two = self::toSecs($comp); if ($one < $two) return $date;
	return $comp;
}

public static function later($date, $comp) {
 // returns later of $date and $comp
	return self::earlier($comp, $date);
}
public static function isprior($date, $comp) {
 // returns true if $date preceeds $comp
	return (self::prior($date, $comp) == $date);
}
public static function islater($date, $comp) {
 // returns true if $date is past $comp
	return self::isprior($comp, $date);
}

// ***********************************************************
// calculating with dates
// ***********************************************************
public static function now($offset = 0, $format = DATE_FMT) {
 // $offset = number of days from now, e.g. +7, 7 or -7
	return self::addDays(time(), $offset, $format);
}
public static function calc($date, $offset = 1, $format = DATE_FMT) {
	$dat = self::toSecs($date);
	return self::addDays($dat, $offset, $format);
}

// ***********************************************************
private static function addDays($timestamp, $offset, $format = DATE_FMT) {
	$ofs = $offset * self::$lenDay;
	$out = $timestamp + $ofs; if (! $format) return $out;
	return date($format, $out);
}

public static function difDays($first, $second) {
 // returns number of days between $first and $second
	$one = self::toSecs($first);
	$two = self::toSecs($second);
	return intval(($one - $two) / self::$lenDay);
}

// ***********************************************************
public static function next($what = "Monday") {
	return self::find("next week $what");
}
public static function last($what = "Monday") {
	return self::find("last week $what");
}
public static function first($what = "Monday", $mon = false, $year = false) {
	$yir = self::chkYear($year);
	$mon = self::chkMonth($mon);
	return self::find("first $what $yir-$mon");
}

public static function firstOfMonth($date) {
	$yir = self::get($date, "Y");
	$mon = self::get($date, "m");
	return self::make($yir, $mon, 1);
}

public static function firstOfWeek($date) {
	$wkd = self::weekday($date);
	return self::calc($date, $wkd * -1 + 1);
}

private static function find($what) {
	$out = strtotime($what);
	return self::get($out);
}

public static function weekday($date) {
	$wkd = self::get($date, "w");
	return ($wkd == 0) ? 7 : $wkd;
}

// ***********************************************************
// conversions
// ***********************************************************
public static function split($date) {
	return array(
		"y" => intval(self::get($date, "Y")),
		"m" => intval(self::get($date, "m")),
		"d" => intval(self::get($date, "d")),
		"h" => intval(self::get($date, "H")),
		"n" => intval(self::get($date, "n")),
	);
}

public static function get($date = false, $format = DATE_FMT) {
	$dat = $date; if (! $dat) return date($format);
	$dat = self::toSecs($dat);
	return date($format, $dat);
}
public static function long($date) { return self::get($date, DATE_FMT." H:i"); }
public static function date($date) { return self::get($date, DATE_FMT); }
public static function time($date) { return self::get($date, "H:i"); }

public static function toSecs($string) { // return time stamp
	$dat = self::strip($string); if (! $dat) return false;
	if (is_numeric($dat)) return $dat;

	if ($out = strtotime($dat)) return $out; $dat = str_replace(".", "/", $dat);
	if ($out = strtotime($dat)) return $out; $dat = str_replace("/", "-", $dat);
	if ($out = strtotime($dat)) return $out;
	return false;
}

// ***********************************************************
// sorting data
// ***********************************************************
public static function sort($arr, $key, $sort = "asc") {
	$tmp = $out = array();

	foreach ($arr as $key => $rec) {
		$crt = VEC::get($rec, $key); if (! $crt) continue;
		$crt = self::strip($crt);
		$crt = self::ymd($crt);

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
