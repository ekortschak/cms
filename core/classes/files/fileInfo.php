<?php
/* ***********************************************************
// INFO
// ***********************************************************
This is used to handle file information

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("files/fileInfo.php");

$obj = new fileInfo($file);
$xxx = $obj->read($file);
$vls = $obj->getInfo();
$txt = $obj->insVars($txt);

*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class fileInfo extends objects {
	private $fil = "";

// ***********************************************************
function __construct($file = "") {
    $this->getInfo($file);
    $this->fil = $file;
}

// ***********************************************************
// setting & retrieving info
// ***********************************************************
public function read($file) {
	$this->fil = $file;
	$this->vls = array(); if (! is_file($file)) return false;
	$inf = pathinfo($file);

	$this->setName($inf, $file);
	$this->setExt($inf);
	$this->setSize($file);
	$this->setDate($file);
}

public function getInfo($ful) {
	return $this->vls;
}

// ***********************************************************
private function setName($inf, $ful) {
	$url = APP::relPath($ful);

	$this->set("full", $ful);
    $this->set("path", $inf["dirname"]);
	$this->set("file", $inf["basename"]); // file name including ext
    $this->set("name", $inf["filename"]); // file name without ext
	$this->set("url",  $url);
	$this->set("link", $url);
	$this->set("icon", $url);
	$this->set("md5",  md5_file($ful));

 // remove leading numbers and extension from dir like in 10.xxx.jpg
    $this->set("caption", PRG::clrDigits($inf["filename"]));
	$this->set("vis", $this->bulb($ful));
}

private function bulb($idx) {
	if (FSO::isHidden($idx)) return "off";
	return "on";
}

// ***********************************************************
private function setExt($inf) {
	$ext = VEC::get($inf, "extension", "");
	$this->set("ext", $ext);
	$this->set("ext3", STR::left($ext));
}

// ***********************************************************
private function setSize($ful) {
	$siz = filesize($ful);
	$this->set("size", $siz);
	$this->set("sfmt", $this->fmtSize($siz)); // size formated, e.g. "12.34 MB"
}

private function fmtSize($size) {
	$arr = STR::toArray("KB,MB,GB,TB");

	foreach ($arr as $key => $unit) {
		$size /= 1000; if ($size < 1000)
		return sprintf("%01.1f", $size)." $unit";
	}
	return "? Bytes";
}

// ***********************************************************
private function setDate($ful) {
	$dat = filemtime($ful);
	$this->set("date", DAT::Ymd($dat));
	$this->set("time", DAT::Time($dat));
	$this->set("dnt",  DAT::YmdTime($dat));
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
