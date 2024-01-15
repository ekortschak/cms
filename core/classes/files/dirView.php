<?php

/* ***********************************************************
// INFO
// ***********************************************************
This class is designed to visualize directory and file listings.

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("files/dirView.php");

$obj = new dirView();
$obj->read($tpl);
$obj->readTree($dir);
$obj->show();
*/

incCls("files/fileInfo.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class dirView extends tpl {
	private $dir = "";
	private $vrz = array();
	private $fls = array();
	private $ext = array();

	private $sort = "asc";

// ***********************************************************
function __construct() {
	parent::__construct();

	$this->load("modules/fview.gallery.tpl");
	$this->register();

	$this->set("title", "No title");
	$this->set("visOnly", true);
}

// ***********************************************************
// Verzeichnis auslesen
// ***********************************************************
public function readTree($dir, $ext = false) {
	$this->dir = APP::dir($dir); if (! $this->dir) return;
	$this->vrz = FSO::dTree($this->dir);
	$this->setExt($ext);

	$fls = FSO::files($dir, "*");
	$fls = FSO::filter($fls, $ext);

	$this->fls = $this->doSort($fls);
}

// ***********************************************************
// DISLPLAY
// ***********************************************************
public function gc($sec = "main") {
	$this->set("curloc",  $this->dir);
	$this->set("folders", $this->folders());
	$this->set("thumbs",  $this->thumbs());
	$this->set("files",   $this->files());
	$this->set("first",   $this->first());
	$this->set("url",     $this->first());

	return parent::gc($sec);
}

// ***********************************************************
// handling folders
// ***********************************************************
private function folders() {
	$lin = $this->getSection("Folder"); if (! $lin) return "";
	$out = array(); if (! $this->vrz) return "";

	foreach ($this->vrz as $dir => $nam) {
		$txt = STR::clear($dir, $this->dir); if (! $txt) continue;

		$this->set("path", $dir);
		$this->set("text", $txt);

		$out[] = $this->getSection("folder");
	}
	return implode("\n", $out);
}

// ***********************************************************
// handling files
// ***********************************************************
private function thumbs() {
	$dir = FSO::join($this->dir, ".thumbs"); if (is_dir($dir))
	return $this->files("thumb");
	return $this->files("file");
}

private function files($what = "file") {
	$lin = $this->getSec($what)."\n"; $out = "";
	$inf = new fileInfo();

	foreach($this->fls as $fil => $nam) {
		$xxx = $inf->read($fil);
 		$out.= $inf->insVars($lin);
	}
	if ($out) return $out;
	return $this->getSection("nofiles");
}

private function first() {
	return VEC::getFirst($this->fls);
}

// ***********************************************************
// sort order
// ***********************************************************
public function setSort($value) {
	$val = STR::left($value, 3);

	switch ($val) {
		case "asc": case "des": break;
		default: $val = "";
	}
	$this->sort = $val;
}

private function doSort($arr) {
	if ($this->sort == "asc")  asort($arr);
	if ($this->sort == "des") arsort($arr);
	return $arr;
}

// ***********************************************************
// file extensions
// ***********************************************************
public function setExt($ext) {
	switch ($ext) {
		case "pics": $ext = "jpg,png,gif"; break;
	}
	$arr = STR::toArray($ext);

	foreach ($arr as $itm) {
		$itm = STR::left($itm);
		$this->ext[$itm] = $itm;
	}
}

public function inExt($fil) {
	$ext = FSO::ext($fil);
	$out = VEC::get($this->ext, "*" ); if ($out) return true;
	$out = VEC::get($this->ext, $ext); if ($out) return true;
	return false;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
