<?php
/* ***********************************************************
// INFO
// ***********************************************************
checking values

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("system/check.php");

$var = CHK::range($val, $max, $min);

*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class CHK {

public static function list($val, $list, $default) {
    if (STR::contains(".$list.", ".$val.")) return $val;
    return $default;
}

public static function range($val, $max, $min = 0) {
	if ($min > $max) { $tmp = $max; $max = $min; $min = $tmp; }
	$val = self::min($val, $min);
	return self::max($val, $max);
}
public static function min($val, $min) {
    return ($val < $min) ? $min : $val;
}
public static function max($val, $max) {
    return ($val > $max) ? $max : $val;
}

public static function len($str, $min, $max) {
    if (strlen($str) > $max) return false;
    if (strlen($str) < $min) return false;
    return true;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
