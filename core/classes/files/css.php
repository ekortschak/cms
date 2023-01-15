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
	private $dir = "static";
	private $cms = "static/cms.css";

function __construct() {
	CFG::readCss();
}

// ***********************************************************
// get style sheet
// ***********************************************************
public function get() { // get style sheet
	$css = $this->gc();

 // send header
	header("Content-Description: File Transfer");
	header("Content-Type: text/css");
	header("Content-Length: ".strlen($css));
	header("Content-Transfer-Encoding: binary\n");
	echo $css;
}

// ***********************************************************
public function gc() { // get code
	$css = $this->getCss();
	return CFG::insert($css);
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
	return $css;
}

// ***********************************************************
// handling stored files
// ***********************************************************
public function save() {
	FSO::kill($this->cms);

	$css = "/* STATIC FILE: $this->cms /*\n\n";
	$css.= $this->gc();
	$css = $this->saveRes($css);

	return APP::write($this->cms, $css);
}

private function saveRes($css) {
	$arr = STR::find($css, 'url("', '"');

	foreach ($arr as $res) {
		$src = STR::after($res, CMS_URL);
		$dst = FSO::join($this->dir, $src);
		$css = STR::replace($css, $res, $dst);

		FSO::copy($src, $dst);
	}
	return $css;
}

public function drop() {
	if (! is_file($this->cms)) return;
	unlink($this->cms);
}

public function statFile() {
	return $this->cms;
}

// ***********************************************************
// handling ck4 files
// ***********************************************************
public function export($file) {
	$fil = "static/$file.css";
	$css = "/* STATIC FILE for CK4 only: $fil /*\n\n";
	$css.= $this->gc();
	return APP::write($fil, $css);
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
		$set = FSO::join(LOC_CSS, $val);
		$set = APP::files($set, "*.css");
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
