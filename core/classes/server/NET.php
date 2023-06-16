<?php
/* ***********************************************************
// INFO
// ***********************************************************
connectivity tools

*/

NET::init();

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class NET {
	private static $con = false;
	private static $geo = false;

public static function init() {
    self::$con = @fsockopen("www.google.com", 80); if (self::$con) fclose(self::$con);
	self::$geo = self::geoData();
}

// ***********************************************************
// methods
// ***********************************************************
public static function isCon() {
	return (bool) self::$con;
}

// ***********************************************************
// reading web pages
// ***********************************************************
public static function read($url) {
	$con = curl_init();
	$xxx = curl_setopt($con, CURLOPT_HEADER, 0);
	$xxx = curl_setopt($con, CURLOPT_URL, $url);
	$xxx = curl_setopt($con, CURLOPT_SSL_VERIFYPEER, 0);
	$xxx = curl_setopt($con, CURLOPT_SSL_VERIFYHOST, 0);
	$xxx = curl_setopt($con, CURLOPT_RETURNTRANSFER, 1);
	$xxx = curl_setopt($con, CURLOPT_FOLLOWLOCATION, 1);
	$xxx = curl_setopt($con, CURLOPT_USERAGENT, "mozilla");
	return curl_exec($con);
}

// ***********************************************************
// geoDataation
// ***********************************************************
private static function geoData() {
return;
	if (! self::$con) return;

	$out = file_get_contents("http://www.geoplugin.net/php.gp?ip=".USER_IP);
	$out = unserialize($out);
	return $out;
}

public static function geoCountry() { return self::geoInfo("countryCode"); }
public static function geoTime()    { return self::geoInfo("locationAccuracyRadius"); }
public static function geoLat()     { return self::geoInfo("latitude"); }
public static function geoLong()    { return self::geoInfo("longitude"); }

public static function geoAcc() {
	$out = self::geoInfo("locationAccuracyRadius");

	if ($out <=  15) return 1;
	if ($out <=  25) return 2;
	if ($out <=  50) return 3;
	if ($out <= 100) return 4;
	return 5;
}

public static function geoInfo($what, $default = "") {
	if (! self::$geo) return $default;
	return VEC::get(self::$geo, "geoplugin_$what");
}

// ***********************************************************
// debugging
// ***********************************************************
private static function isErr($txt) {
	$txt = STR::between($txt, "<title>", " ");
	return (is_numeric($txt));
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
