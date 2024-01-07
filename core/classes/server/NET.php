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
	ob_start();
    NET::$con = @fsockopen("www.google.com", 80); if (NET::$con) fclose(NET::$con);
	NET::$geo = NET::geoData();
	ob_flush();
}

// ***********************************************************
// methods
// ***********************************************************
public static function isCon() {
	return (bool) NET::$con;
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
	if (! NET::$con) return;

	$out = file_get_contents("http://www.geoplugin.net/php.gp?ip=".USER_IP);
	$out = unserialize($out);
	return $out;
}

public static function geoCountry() { return NET::geoInfo("countryCode"); }
public static function geoTime()    { return NET::geoInfo("locationAccuracyRadius"); }
public static function geoLat()     { return NET::geoInfo("latitude"); }
public static function geoLong()    { return NET::geoInfo("longitude"); }

public static function geoAcc() {
	$out = NET::geoInfo("locationAccuracyRadius");

	if ($out <=  15) return 1;
	if ($out <=  25) return 2;
	if ($out <=  50) return 3;
	if ($out <= 100) return 4;
	return 5;
}

public static function geoInfo($what, $default = "") {
	if (! NET::$geo) return $default;
	return VEC::get(NET::$geo, "geoplugin_$what");
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
