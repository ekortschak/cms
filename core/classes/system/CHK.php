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
// user
// ***********************************************************
public static function user($usr) {
	if (STR::contains($usr, " ")) return false;
	return (strlen($usr) > 2);
}

public static function pwd($pwd, $agn = NV) {
	if ($agn !== NV)                        if ($pwd != $agn) return false;
	$chk = PRG::replace($pwd, "\d",    ""); if ($pwd == $chk) return false;
	$chk = PRG::replace($pwd, "[A-z]", ""); if ($pwd == $chk) return false;

	return (strlen($pwd) > 5);
}

// ***********************************************************
// urls
// ***********************************************************
public static function isUrl($url) {
    $chk = curl_init();
    curl_setopt($chk, CURLOPT_URL, $url);
    curl_setopt($chk, CURLOPT_HEADER, 1);
    curl_setopt($chk, CURLOPT_RETURNTRANSFER, 1);

    $dat = curl_exec($chk);
    $arr = curl_getinfo($chk);
    curl_close($chk);

	$out = $arr['http_code'];
	return ($out < 400);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>