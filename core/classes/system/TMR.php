<?php
/* ***********************************************************
// INFO
// ***********************************************************
Timer functionality ...

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("system/TMR.php");

TMR::lapse($info);
TMR::total($info);
*/

TMR::init();

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class TMR {
	private static $sTime = 0;
	private static $cTime = 0;

	private static $dat = array();

public static function init() {
	self::$sTime = self::$cTime = microtime(true);
}

// ***********************************************************
public static function total($info = NV) { // get total runtime
	return self::doTime(self::$sTime, $info);
}
public static function punch($info = NV) { // get elapsed time
	return self::doTime(self::$cTime, $info);
}

public static function get() {
	return self::$dat();
}

// ***********************************************************
private static function doTime($ref, $key = NV) {
	if ($key === NV) $key = uniqid();
	
	$cur = microtime(true);
	$dif = sprintf("%1.3fs", $cur - $ref);
	
	self::$cTime = $cur;
	self::$dat[$key] = $dif;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************

?>
