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

# include_once("core/inc.css.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class css {
	private $cms = "static/cms.css";

function __construct() {
	CFG::readCss();
}

// ***********************************************************
// get style sheet
// ***********************************************************
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
public function gc() { // get code
	return $this->getCss();
}

// ***********************************************************
private function getCss() {
	$css = $this->getStatic(); if ($css) return $css;
	$arr = $this->getFiles();
	$css = "";

	foreach ($arr as $file) {
		$css.= APP::read($file);
		$css.= "\n";
	}
#	$css = $this->compress($css);
	$css = $this->cleanUrls($css, 'url("', '"');
	$css = $this->cleanUrls($css, "url(",  ")");

 // replace css constants
	return CFG::insert($css);
}

// ***********************************************************
// handling stored files
// ***********************************************************
public function save($overwrite = true) {
	FSO::kill($this->cms);

	$css = "/* STATIC FILE: $this->cms /*\n\n";
	$css.= $this->getCss();
	return APP::write($this->cms, $css, $overwrite);
}

public function drop() {
	if (! is_file($this->cms)) return;
	unlink($this->cms);
}

// ***********************************************************
// handling ck4 files
// ***********************************************************
public function export($file) {
	$fil = "static/$file.css";
	$css = "/* STATIC FILE for CK4 only: $fil /*\n\n";
	$css.= $this->getCss();
	return APP::write($fil, $css, true);
}

// ***********************************************************
// read all css files from styles folder(s) into array
// ***********************************************************
private function getStatic() {
	$ful = APP::file($this->cms); if (! $ful) return false;
	$out = file_get_contents($ful);
	return trim($out);
}

// ***********************************************************
private function getFiles() {
	$arr = $lst = $chk = array();

	$sets = array( // assoc to avoid dups
		"default" => "default",
		 LAYOUT   => LAYOUT,
		"app"     => ""
	);
	foreach ($sets as $val) {
		$set = FSO::join(LOC_CSS, $val, "*.css");
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
		$ful = STR::clear($fil, APP_DIR);
		$str = str_replace($fil, $ful, $str);
	}
	return $str;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
