<?php
/* ***********************************************************
// INFO
// ***********************************************************
handling regular array tasks

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("system/VEC.php");

$str = VEC::xform($arr, $name);
*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class VEC {

// ***********************************************************
// creating arrays
// ***********************************************************
public static function range($min, $max) {
	$arr = range($min, $max);
	return VEC::toAssoc($arr);
}

// ***********************************************************
// converting arrays
// ***********************************************************
public static function xform($arr, $name = false) {
	if (! is_array($arr)) return $arr;

	$out = print_r($arr, true);
#	$out = str_replace("\r", "", $out);
	$out = str_replace("\n\n", "\n", $out);
	$out = str_replace("  ", " ", $out);
    $out = preg_replace("~\n\s+\(~", " (", $out); // opening braces should go with previous line

	$cap = "Array ("; if ($name) $cap = "$name (";
	$out = str_replace("Array\n(", $cap, $out);
	return $out;
}

// ***********************************************************
public static function toAssoc($arr, $mds = "vals") {
	switch ($mds) {
		case "keys": $out = array_keys($arr); break;
		default:     $out = array_values($arr);
	}
	return array_combine($out, $out);
}

// ***********************************************************
public static function toText($arr, $pfx = "") {
	if (! $arr) return "";
	if (! is_array($arr)) return $pfx.$arr."\n"; $out = "";

	foreach ($arr as $key => $val) {
		if (is_numeric($key)) {
			$key++;
			if (count($val) < 2) {
				if (is_array($val)) $val = current($val);
				$out.= "$pfx$key. $val\n";
			}
			continue;
		}
		$out.= $pfx.$key."\n";
		$out.= self::toText($val, $pfx."\t");
	}
	return $out;
}

// ***********************************************************
public static function explode($text, $sep = ",", $max = 0) {
	$out = array(); if (is_array($text)) return $text;

	switch ($max) {
		case 0:  $arr = explode($sep, $text); break;
		default: $arr = explode($sep, $text, $max);
	}
	foreach ($arr as $val) {
		$out[] = trim($val);
	}
	if ($max)
	$out = array_pad($out, $max, "");
	return $out;
}

// ***********************************************************
// retrieving items
// ***********************************************************
public static function lng($lng, $arr, $key, $default = false) {
	$out = self::get($arr, "$key.$lng", NV); if ($out !== NV) return $out;
	return self::get($arr,  $key, $default);
}

public static function get($arr, $key, $default = false) {
	if (! $arr) return $default;
	if (! isset($arr[$key])) return $default;
	return      $arr[$key];
}

public static function indexOf($data, $sel, $default = false) {
	if (! is_array($data)) return $default;

	$arr = array_keys($data);
	$out = array_search($sel, $arr); if ($out !== false) return $out;
	return $default;
}

public static function find($data, $sel, $default = false) {
	if (! is_array($data)) return $default;
	if (self::get($data, $sel)) return $sel;

	foreach ($data as $key => $val) {
		if ($sel === $val) return $key;
	}
	return self::getFirst($data);
}

public static function getFirst($data) {;
	if (! $data) return ""; reset($data);
	return key($data);
}

public static function keys($data) {
	if (! is_array($data)) return array();
	$out = array_keys($data);
	return array_combine($out, $out);
}
public static function nums($data, $pfx) {
	$out = array(); $cnt = 1;

	foreach ($data as $key => $val) {
		$out[$key] = "$pfx ".$cnt++;
	}
	return $out;
}

public static function match($data, $pfx = "") {
	$out = array();

	foreach ($data as $key => $val) {
		if (! $key) continue;

		if ($pfx) if (! STR::begins($key, $pfx)) continue;
		if ($pfx) $key = STR::after($key, array("$pfx.", $pfx));
		if ($key) $out[$key] = $val;
	}
	return $out;
}

// ***********************************************************
// enlarging arrays
// ***********************************************************
public static function append($arr, $key, $value, $glue = "") {
	$val = self::get($arr, $key, ""); if ($val == "") $glue = "";
	$arr[$key] = $val.$glue.$value;
	return $arr;
}

public static function drop($arr, $value) {
	$out = array(); if (! $arr) return $out;

	foreach ($arr as $key => $val) {
		if ($val == $value) continue;
		if (is_numeric($key)) $out[] = $val;
		else $out[$key] = $val;
	}
	return $out;
}
public static function purge($arr, $vals) {
	$out = array(); if (! $arr) return $out;

	foreach ($arr as $key => $val) {
		if (STR::begins($val, $vals)) continue;
		if (is_numeric($key)) $out[] = $val;
		else $out[$key] = $val;
	}
	return $out;
}

public static function merge($arr1, $arr2) {
	if (! is_array($arr2)) return $arr1;
	return array_merge($arr1, $arr2);
}

public static function implode($arr, $sep = "\n") {
	if (! is_array($arr)) return trim($arr); $out = array();

	foreach ($arr as $itm) {
		if ($itm) $out [] = trim($itm);
	}
	return implode($sep, $out);
}

// ***********************************************************
// diverse operations
// ***********************************************************
public static function isKey($arr, $key) {
	return isset($arr[$key]);
}

public static function count(&$arr, $key) {
	$old = self::get($arr, $key, 0);
	return $arr[$key] = $old + 1;
}

// ***********************************************************
// sorting data
// ***********************************************************
public static function sortByLen($arr) {
	$out = $tmp = array();
	foreach ($arr as $key => $val) {
		$tmp[$key] = strlen($val);
	}
	arsort($tmp);

	foreach ($tmp as $key => $val) {
		$out[$key] = $arr[$key];
	}
	return $out;
}

// ***********************************************************
// filtering data
// ***********************************************************
public static function filter($arr, $crit, $key = false) {
	$out = array(); if (! $arr) return false;
	$crt = self::getCrit($crit);

	foreach ($arr as $rec) {
		$vgl = self::implode($rec, "|");

		if ($crt["ign"]) if (  STR::contains($vgl, $crt["ign"])) continue;
		if ($crt["yes"]) if (! STR::contains($vgl, $crt["yes"])) continue;

		if ($key) $out[$rec[$key]] = $rec;
		else      $out[] = $rec;
	}
	return $out;
}

private static function getCrit($lst) {
	$lst = trim($lst); if (! $lst) return;
	$lst = str_replace(",", " ", $lst);
	$lst = str_replace("  ", " ", $lst);
	$lst = explode(" ", $lst);
	$out = array("ign" => array(), "yes" => array());

	foreach ($lst as $itm) {
		$itm = trim($itm); if (! $itm) continue;

		if (STR::begins($itm, array("+", "-"))) {
			$str = trim(substr($itm, 2));
			if (STR::begins($itm, "-")) $out["ign"][] = $str;
			if (STR::begins($itm, "+")) $out["yes"][] = $str;
		} else {
			$out["yes"][] = $itm;
		}
	}
	return $out;
}

public static function add(&$arr, $key, $add = 1) {
	$cur = self::get($arr, $key, 0);
	return $arr[$key] = ++$cur;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
