<?php
/* ***********************************************************
// INFO
// ***********************************************************
- contains methods concerning gps coordinates

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("other/gps.php");

$gps = new gps();
$gps->home($lon, $lat);

$dif = $gps->($lon, $lat);

*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class gps {
	private $lon = 46.9514; // longitude
	private $lat = 14.4116; // lattitude

function __construct() {}

public function home($lon, $lat) {
	$this->lon = $lon;
	$this->lat = $lat;
}
	
public function distance($lon, $lat) {
	return $this->calc($lat, $lon, $this->lat, $this->lon);
}

private function calc($lat1, $lon1, $lat2, $lon2) {
	$lat1 = deg2rad($lat1);
	$lat2 = deg2rad($lat2);
	$lon  = deg2rad($lon1 - $lon2);
	
	$dis = sin($lat1) * sin($lat2) + cos($lat1) * cos($lat2) * cos($lon);
	$dis = acos($dis);
	$out = rad2deg($dis);

	$out = $out * 60 * 1.1515;
	$out = $out * 1609.344;
	$out = round($out, 2);

	return $out;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
