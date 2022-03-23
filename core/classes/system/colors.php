<?php
/* ***********************************************************
// INFO
// ***********************************************************
// from http://serennu.com/colour/rgbtohsl.php

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("input/any.php");

$clr = new color();

$clr->setColor("Named Color");
$hsl = $clr->getHsl();
$cmp = $clr->findComplement($hsl);
$cmp = $clr->conv2hex($cmp);
$sat/= 10;

*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class color {
	private $rgb = array(0, 0, 0);  // rgb representation of color
	private $hsl = array(0, 0, 0);
	private $hex = "000000";

	private $names = array();

function __construct() {
	$this->names = array(
		"AliceBlue" =>"F0F8FF",			"AntiqueWhite" =>"FAEBD7",
		"Aqua" =>"00FFFF",				"Aquamarine" =>"7FFFD4",
		"Azure" =>"F0FFFF",				"Beige" =>"F5F5DC",
		"Bisque" =>"FFE4C4",			"Black" =>"000000",
		"BlanchedAlmond" =>"FFEBCD",	"Blue" =>"0000FF",
		"BlueViolet" =>"8A2BE2",		"Brown" =>"A52A2A",
		"BurlyWood" =>"DEB887",			"CadetBlue" =>"5F9EA0",
		"Chartreuse" =>"7FFF00",		"Chocolate" =>"D2691E",
		"Coral" =>"FF7F50",				"CornflowerBlue" =>"6495ED",
		"Cornsilk" =>"FFF8DC",			"Crimson" =>"DC143C",
		"Cyan" =>"00FFFF",				"DarkBlue" =>"00008B",
		"DarkCyan" =>"008B8B",			"DarkGoldenRod" =>"B8860B",
		"DarkGray" =>"A9A9A9",			"DarkGreen" =>"006400",
		"DarkKhaki" =>"BDB76B",			"DarkMagenta" =>"8B008B",
		"DarkOliveGreen" =>"556B2F",	"Darkorange" =>"FF8C00",
		"DarkOrchid" =>"9932CC",		"DarkRed" =>"8B0000",
		"DarkSalmon" =>"E9967A",		"DarkSeaGreen" =>"8FBC8F",
		"DarkSlateBlue" =>"483D8B",		"DarkSlateGray" =>"2F4F4F",
		"DarkTurquoise" =>"00CED1",		"DarkViolet" =>"9400D3",
		"DeepPink" =>"FF1493",			"DeepSkyBlue" =>"00BFFF",
		"DimGray" =>"696969",			"DodgerBlue" =>"1E90FF",
		"FireBrick" =>"B22222",			"FloralWhite" =>"FFFAF0",
		"ForestGreen" =>"228B22",		"Fuchsia" =>"FF00FF",
		"Gainsboro" =>"DCDCDC",			"GhostWhite" =>"F8F8FF",
		"Gold" =>"FFD700",				"GoldenRod" =>"DAA520",
		"Gray" =>"808080",				"Green" =>"008000",
		"GreenYellow" =>"ADFF2F",		"HoneyDew" =>"F0FFF0",
		"HotPink" =>"FF69B4",			"IndianRed" =>"CD5C5C",
		"Indigo" =>"4B0082",			"Ivory" =>"FFFFF0",
		"Khaki" =>"F0E68C",				"Lavender" =>"E6E6FA",
		"LavenderBlush" =>"FFF0F5",		"LawnGreen" =>"7CFC00",
		"LemonChiffon" =>"FFFACD",		"LightBlue" =>"ADD8E6",
		"LightCoral" =>"F08080",		"LightCyan" =>"E0FFFF",
		"LightGoldenRod" =>"FAFAD2",	"LightGrey" =>"D3D3D3",
		"LightGreen" =>"90EE90",		"LightPink" =>"FFB6C1",
		"LightSalmon" =>"FFA07A",		"LightSeaGreen" =>"20B2AA",
		"LightSkyBlue" =>"87CEFA",		"LightSlateGray" =>"778899",
		"LightSteelBlue" =>"B0C4DE",	"LightYellow" =>"FFFFE0",
		"Lime" =>"00FF00",				"LimeGreen" =>"32CD32",
		"Linen" =>"FAF0E6",				"Magenta" =>"FF00FF",
		"Maroon" =>"800000",			"MediumAquaMairne" =>"66CDAA",
		"MediumBlue" =>"0000CD",		"MediumOrchid" =>"BA55D3",
		"MediumPurple" =>"9370D8",		"MediumSeaGreen" =>"3CB371",
		"MediumSlateBlue" =>"7B68EE",	"MediumSpringGreen" =>"00FA9A",
		"MediumTurquoise" =>"48D1CC",	"MediumVioletRed" =>"C71585",
		"MidnightBlue" =>"191970",		"MintCream" =>"F5FFFA",
		"MistyRose" =>"FFE4E1",			"Moccasin" =>"FFE4B5",
		"NavajoWhite" =>"FFDEAD",		"Navy" =>"000080",
		"OldLace" =>"FDF5E6",			"Olive" =>"808000",
		"OliveDrab" =>"6B8E23",			"Orange" =>"FFA500",
		"OrangeRed" =>"FF4500",			"Orchid" =>"DA70D6",
		"PaleGoldenRod" =>"EEE8AA",		"PaleGreen" =>"98FB98",
		"PaleTurquoise" =>"AFEEEE",		"PaleVioletRed" =>"D87093",
		"PapayaWhip" =>"FFEFD5",		"PeachPuff" =>"FFDAB9",
		"Peru" =>"CD853F",				"Pink" =>"FFC0CB",
		"Plum" =>"DDA0DD",				"PowderBlue" =>"B0E0E6",
		"Purple" =>"800080",			"Red" =>"FF0000",
		"RosyBrown" =>"BC8F8F",			"RoyalBlue" =>"4169E1",
		"SaddleBrown" =>"8B4513",		"Salmon" =>"FA8072",
		"SandyBrown" =>"F4A460",		"SeaGreen" =>"2E8B57",
		"SeaShell" =>"FFF5EE",			"Sienna" =>"A0522D",
		"Silver" =>"C0C0C0",			"SkyBlue" =>"87CEEB",
		"SlateBlue" =>"6A5ACD",			"SlateGray" =>"708090",
		"Snow" =>"FFFAFA",				"SpringGreen" =>"00FF7F",
		"SteelBlue" =>"4682B4",			"Tan" =>"D2B48C",
		"Teal" =>"008080",				"Thistle" =>"D8BFD8",
		"Tomato" =>"FF6347",			"Turquoise" =>"40E0D0",
		"Violet" =>"EE82EE",			"Wheat" =>"F5DEB3",
		"White" =>"FFFFFF",				"WhiteSmoke" =>"F5F5F5",
		"Yellow" =>"FFFF00",			"YellowGreen" =>"9ACD32",
	);
}
// ***********************************************************
function setColor($col) {
	if (is_array($col))                $this->setRGBarr($col);
	elseif (STR::contains($col, ","))  $this->setRGB($col);
	elseif (isset($this->names[$col])) $this->setNamed($col);
	else                               $this->setHex($col);
	return $this->hex;
}
// ***********************************************************
private function setRGB($red, $grn, $blu) {
	$this->rgb = array($red, $grn, $blu);
	$this->hsl = $this->conv2hsl($this->rgb);
	$this->hex = $this->conv2hex($this->rgb);
}
// ***********************************************************
private function setRGBstr($col) {
	$col = STR::toArray($col);
	$this->setRGBarr($col);
}
// ***********************************************************
private function setRGBarr($col) {
	$this->setRGB($col[0], $col[1], $col[2]);
}
// ***********************************************************
private function setHex($col) {
    $red = hexdec(substr($col, 0, 2));
    $grn = hexdec(substr($col, 2, 2));
    $blu = hexdec(substr($col, 4, 2));

	$this->setRGB($red, $grn, $blu);
}
// ***********************************************************
private function setNamed($col) {
	if (is_numeric($col))
	$col = VEC::get($this->getNames(), $col, $col);
	$out = VEC::get($this->names, $col); if ($out) return $out;
	return ERR::msg("color.unknown", $col);
}
// ***********************************************************
// convert between color codes
// ***********************************************************
function conv2hex($rgb) {
	$out = "";
	foreach ($rgb as $itm) {
		$out.= sprintf("%02X", round($itm));
	}
	return $out;
}
// ***********************************************************
// conversion between rgb and hsl values
// ***********************************************************
private function conv2hsl($rgb) {
	$red = $rgb[0] / 255;
	$grn = $rgb[1] / 255;
	$blu = $rgb[2] / 255;

    $min = min($red, $grn, $blu);
    $max = max($red, $grn, $blu);

    $dif = $max - $min; if ($dif == 0) return array(0, 0, 0);
	$sum = $max + $min;
    $lum = $this->chkParm($sum / 2);
    $sat = $dif / (2 - $sum); if ($lum < 0.5) $sat = $dif / $sum;

    $xxr = ((($max - $red) / 6) + ($dif / 2)) / $dif;
    $xxg = ((($max - $grn) / 6) + ($dif / 2)) / $dif;
    $xxb = ((($max - $blu) / 6) + ($dif / 2)) / $dif;

	switch ($max) {
		case $red: $hue = (0 / 3) + $xxb - $xxg; break;
		case $grn: $hue = (1 / 3) + $xxr - $xxb; break;
		case $blu: $hue = (2 / 3) + $xxg - $xxr; break;
	}
	$hue = $this->chkParm($hue);
	$sat = $this->chkParm($sat);
	$lum = $this->chkParm($lum);

	return array($hue, $sat, $lum);
}
// ***********************************************************
private function conv2rgb($hsl) {
	$hue = $hsl[0];
	$sat = $hsl[1];
	$lum = $hsl[2];
	$li2 = $lum; if ($lum < 0.5) $li2 = $lum + 1;

    if ($sat == 0) return array($lum * 255, $lum * 255, $lum * 255);

    if ($lum < 0.5) $var_2 = $lum * (1 + $sat);
    else			$var_2 = ($lum + $sat) - ($sat * $lum);

	$var_1 = 2 * $lum - $var_2;

    $red = 255 * $this->hue2rgb($var_1, $var_2, $hue + (1 / 3));
    $grn = 255 * $this->hue2rgb($var_1, $var_2, $hue);
    $blu = 255 * $this->hue2rgb($var_1, $var_2, $hue - (1 / 3));

	$red = round($red);
	$grn = round($grn);
	$blu = round($blu);

	return array($red, $grn, $blu);
}
// ***********************************************************
private function hsl2str($hsl) {
	$hsl[0] = round($hsl[0] * 360);
	$hsl[1] = round($hsl[1] * 100);
	$hsl[2] = round($hsl[2] * 100);
	return implode(",", $hsl);
}
// ***********************************************************
private function hue2rgb($v1, $v2, $vh) {
    $v1 = $this->chkParm($v1);
    $v2 = $this->chkParm($v2);
    $vh = $this->chkParm($vh);

    if ((6 * $vh) < 1) return ($v1 + ($v2 - $v1) * 6 * $vh);
    if ((2 * $vh) < 1) return ($v2);
    if ((3 * $vh) < 2) return ($v1 + ($v2 - $v1) * ((2 / 3 - $vh) * 6));
    return ($v1);
}
// ***********************************************************
private function chkParm($prm) {
    if ($prm < 0) return $prm + 1;
    if ($prm > 1) return $prm - 1;
	return $prm;
}
// ***********************************************************
// calculating complementary colors
// ***********************************************************
function findComplement($hsl) {
	return $this->findHue($hsl, 0.5);
}
// ***********************************************************
private function findHue($hsl, $ofs) {
	$hsl[0] = $this->chkParm($hsl[0] + $ofs);
	return $this->conv2rgb($hsl);
}
// ***********************************************************
private function findSat($hsl, $ofs) {
	$hsl[1] = $this->chkParm($hsl[1] + $ofs);
	return $this->conv2rgb($hsl);
}
// ***********************************************************
private function findLum($hsl, $ofs) {
	$hsl[2] = $this->chkParm($hsl[2] + $ofs);
	return $this->conv2rgb($hsl);
}
// ***********************************************************
function findColor($hue, $sat, $lum = 0) {
	$hsl[0] = $this->chkParm($hue);
	$hsl[1] = $this->chkParm($sat);
	$hsl[2] = $this->chkParm($lum);
	return $this->conv2rgb($hsl);
}
// ***********************************************************
// properties
// ***********************************************************
function getNames() {
	return VEC::toAssoc($this->names, "keys");
}
// ***********************************************************
function getHsl() {
	return $this->hsl;
}
// ***********************************************************
// display properties
// ***********************************************************
function show() {
	$rgb = implode(",", $this->rgb);

	$hsl = $this->hsl2str($this->hsl);
	$hsl = $this->conv2rgb($this->hsl);
	$hsl = implode(",", $hsl);

	$tpl = new tpl();
	$tpl->read("design/templates/other/colors.tpl");
	$tpl->set("hex", $this->hex);
	$tpl->set("rgb", $rgb);
	$tpl->set("hsl", $hsl);
	$tpl->show();
}
// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
