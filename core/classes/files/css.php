<?php
/* ***********************************************************
// INFO
// ***********************************************************
used to generate style sheet from chosen directory

// ***********************************************************
// HOW TO USE
// ***********************************************************
include_once("core/inc.css.php");
incCls("files/css.php");

$css = new css();
$css->get();
*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class css {
	private $fil = "design/site.css";

function __construct() {}

// ***********************************************************
// get style sheet
// ***********************************************************
public function gc() { // get code
	return $this->getCss();
}

public function get() { // get style sheet
	$css = $this->getCss();

 // send header
	header("Content-Description: File Transfer");
	header("Content-Type: text/css");
	header("Content-Length: ".strlen($css));
	header("Content-Transfer-Encoding: binary\n");
	echo $css;
}

// ***********************************************************
// handling stored files
// ***********************************************************
public function save($overwrite = 1) {
	$css = "/* STATIC FILE: $this->fil /*\n\n";
	$css.= $this->getCss();
	return APP::write($this->fil, $css, $overwrite);
}

public function drop() {
	if (! is_file($this->fil)) return;
	unlink($this->fil);
}

// ***********************************************************
// retrieving css information
// ***********************************************************
private function getCss() {
	$css = $this->getStatic(); if ($css) return $css;
	$arr = $this->getFiles();
	$css = "";

	foreach ($arr as $file) {
#		$css.= "/* file = $file */\n";
		$css.= APP::read($file);
		$css.= "\n";
	}
#	$css = $this->compress($css);
	$css = $this->cleanUrls($css, 'url("', '"');
	$css = $this->cleanUrls($css, "url(",  ")");

 // replace css constants
	return KONST::insert($css);
}

private function getStatic() {
	$ful = APP::file($this->fil); if (! $ful) return false;
	$out = file_get_contents($ful);
	return trim($out);
}

// ***********************************************************
// read all css files from styles folder(s) into array
// ***********************************************************
private function getFiles() {
	$arr = $lst = $chk = array();

	$sets = array( // assoc to avoid dups
		"default" => "default",
		 LAYOUT   => LAYOUT,
		"app"     => ""
	);
	foreach ($sets as $val) {
		$set = FSO::join("design/styles", $val, "*.css");
		$set = APP::files($set);
		$arr = VEC::merge($arr, $set);
	}
	foreach ($arr as $fil => $nam) {
		if (substr($fil, 0, 1) == ".") continue; // 'hidden style'
		if (! $fil) continue;

		$key = basename($fil, ".css");
		$lst[$key] = $fil;
	}
	ksort($lst); // sort prior to usage
	return $lst;
}

// ***********************************************************
// auxilliary private functions
// ***********************************************************
private function compress($css) {
	$css = PRG::clrComments($css);
	$css = PRG::clrBlanks($css);
	$arr = str_split(":;,{()}-+"); // syntax chars

	foreach ($arr as $chr) {
		$css = str_replace("$chr ", $chr, $css);
		$css = str_replace(" $chr", $chr, $css);
	}
	$css = str_replace("'", '"', $css);
	return trim($css);
}

// ***********************************************************
// remove paths outside localhost
// ***********************************************************
private function cleanUrls($str, $sep1, $sep2) {
	$arr = STR::find($str, $sep1, $sep2);

	foreach ($arr as $fil) {
		$ful = STR::clear($fil, SRV_ROOT);
		$str = str_replace($fil, $ful, $str);
	}
	return $str;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
