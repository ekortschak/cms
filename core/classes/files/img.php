<?php
/* ***********************************************************
// INFO
// ***********************************************************
use this class to
* create images from text
* retrieve pic info

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("input/img.php");

$img = new img();
$img->setColor($fgc, $bgc);
$img->setFont($font, $size);
$img->create($text, $angle);
$img->save($file);

*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class img  {
	private $pic;
	private $fnt = "design/fonts/LiberationSans.ttf";
	private $siz = 12;
	private $fgc = 180;
	private $bgc = 16777215;

function __construct() {
	$fnt = ENV::get("Font", $this->fnt);
	if ($fnt) $this->setFont($fnt);
}

// ***********************************************************
// creating images from text
// ***********************************************************
public function create($text, $angle = 90) {
	$fnt = $this->fnt; $fgc = $this->fgc;
	$siz = $this->siz; $bgc = $this->bgc;

	$box = imagettfbbox($siz, 0, $fnt, $text);
	$lft = $box[0]; $btm = $siz;
	$wid = $box[2]; $hgt = $siz * 1.25;

    $pic = imagecreatetruecolor($wid, $hgt);
    $xxx = imagefilledrectangle($pic, 0, 0, $wid, $hgt, $bgc);
	$xxx = imagecolortransparent($pic, $bgc);
	$xxx = imagettftext($pic, $siz, 0, $lft, $btm, $fgc, $fnt, $text);

	#bg(imagecolorallocate($pic, 255, 255, 255));

	$this->pic = imagerotate($pic, $angle, $bgc, $bgc);
}

public function save($file) {
	imagepng($this->pic, $file);
}

public function preview($file) {
	$tpl = new tpl();
	$tpl->load("other/img.tpl");
	$tpl->set("file", $file);
	$tpl->show("preview");
}

// ***********************************************************
// retrieving pic info
// ***********************************************************
public function getSize($file) {
	if (! is_file($file)) return false;

	$inf = getimagesize($file);
	list($width, $height, $type, $attr) = $inf;

	$out = array(
		"width" => $width, "height" => $height,
		"type" => $type, "attr" => $attr,
	);
	$out["mime"] = $inf["mime"];
	return $out;
}

public function isPortrait($file) {
	$inf = $this->getSize($file); if (! $inf) return false;
	extract($inf);
	return ($width <= $height);
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
public function setFont($font, $size = 12) {
	$this->fnt = APP::file($font);
	$this->siz = $size;
}
public function setColor($fgc, $bgc = 0) {
	$this->fgc = $fgc;
	$this->bgc = $bgc;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
