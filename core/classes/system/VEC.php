<?php
/* ***********************************************************
// INFO
// ***********************************************************
handling regular array tasks

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("system/VEC.php");

$str = VEC::xform($data, $name);
*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class VEC {

// ***********************************************************
// creating arrays
// ***********************************************************
public static function range($min, $max) {
	$data = range($min, $max);
	return VEC::toAssoc($data);
}

// ***********************************************************
// converting arrays
// ***********************************************************
public static function xform($data, $name = false) {
	if (! is_array($data)) return $data;

	$out = print_r($data, true);
	$out = str_replace("\r", "", $out);
	$out = str_replace("\n\n", "\n", $out);
	$out = str_replace("  ", " ", $out);
    $out = preg_replace("~\n\s+\(~", " (", $out); // opening braces should go with previous line

	$cap = "Array ("; if ($name) $cap = "$name (";
	$out = str_replace("Array\n(", $cap, $out);
	return $out;
}

// ***********************************************************
public static function toAssoc($data, $mds = "vals") {
	switch ($mds) {
		case "keys": $out = array_keys($data); break;
		default:     $out = array_values($data);
	}
	return array_combine($out, $out);
}

// ***********************************************************
public static function toText($data, $pfx = "") {
	if (! $data) return "";
	if (! is_array($data)) return $pfx.$data."\n"; $out = "";

	foreach ($data as $key => $val) {
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
		case 0:  $data = explode($sep, $text); break;
		default: $data = explode($sep, $text, $max);
	}
	foreach ($data as $val) {
		$out[] = trim($val);
	}
	if ($max)
	$out = array_pad($out, $max, "");
	return $out;
}

// ***********************************************************
// retrieving items
// ***********************************************************
public static function lng($lng, $data, $key, $default = false) {
	$out = self::get($data, "$key.$lng", NV); if ($out !== NV) return $out;
	return self::get($data,  $key, $default);
}

public static function get($data, $key, $default = false) {
	if (! $data) return $default;
	if (! isset($data[$key])) return $default;
	return      $data[$key];
}

public static function indexOf($data, $sel, $default = false) {
	if (! is_array($data)) return $default;

	$data = array_keys($data);
	$out = array_search($sel, $data); if ($out !== false) return $out;
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
	if (! $pfx) return $data; $out = array();

	foreach ($data as $key => $val) {
		$key = STR::after($key, array("$pfx.", $pfx));
		if ($key) $out[$key] = $val;
	}
	return $out;
}

// ***********************************************************
// handling arrays
// ***********************************************************
public static function append($data, $key, $value, $glue = "") {
	$val = self::get($data, $key, ""); if ($val == "") $glue = "";
	$data[$key] = $val.$glue.$value;
	return $data;
}

public static function drop($data, $value) {
	$out = array(); if (! $data) return $out;

	foreach ($data as $key => $val) {
		if ($val == $value) continue;
		if (is_numeric($key)) $out[] = $val;
		else $out[$key] = $val;
	}
	return $out;
}

public static function purge($data, $vals) {
	$out = array(); if (! $data) return $out;

	foreach ($data as $key => $val) {
		if (STR::begins($val, $vals)) continue;
		if (is_numeric($key)) $out[] = $val;
		else $out[$key] = $val;
	}
	return $out;
}

public static function merge($data1, $data2) {
	if (! is_array($data2)) return $data1;
	return array_merge($data1, $data2);
}

public static function implode($data, $sep = "\n") {
	if (! is_array($data)) return trim($data); $out = array();

	foreach ($data as $itm) {
		if ($itm) $out [] = trim($itm);
	}
	return implode($sep, $out);
}

// ***********************************************************
// diverse operations
// ***********************************************************
public static function isKey($data, $key) {
	return isset($data[$key]);
}

public static function count($data, $key) {
	$old = self::get($data, $key, 0);
	return $data[$key] = $old + 1;
}

// ***********************************************************
// sorting data
// ***********************************************************
public static function sort($arr, $fnc = "ksort") {
	if (! is_array($arr)) return false;
	$fnc($arr); return $arr;
}

public static function sortByLen($data) {
	$out = $tmp = array();
	foreach ($data as $key => $val) {
		$tmp[$key] = strlen($val);
	}
	$tmp = self::sort($tmp, "arsort");

	foreach ($tmp as $key => $val) {
		$out[$key] = $data[$key];
	}
	return $out;
}

// ***********************************************************
// filtering data
// ***********************************************************
public static function filter($data, $crit, $key = false) {
	$out = array(); if (! $data) return false;
	$crt = self::getCrit($crit);

	foreach ($data as $rec) {
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

public static function add($data, $key, $add = 1) {
	$cur = self::get($data, $key, 0);
	return $data[$key] = ++$cur;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
