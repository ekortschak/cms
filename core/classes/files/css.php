<?php
/* ***********************************************************
// INFO
// ***********************************************************
used to generate style sheet from chosen directory

// ***********************************************************
// HOW TO USE
// ***********************************************************
include_once "core/include/load.css.php";

incCls("system/CFG.php");
incCls("files/css.php");

$css = new css();
$css->get();
*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class css {
	private $dir = "static";
	private $cms = "static/cms.css";

function __construct() { }

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
#	$css = $this->getStatic(); if ($css) return $css;
	$arr = $this->getFiles();
	$css = "";

	foreach ($arr as $file) {
		$itm = APP::read($file);
		$itm = $this->fix($itm);
		$css.= $itm;
	}
#	$css = $this->compress($css);
	return CFG::apply($css);
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
		$dst = FSO::join($this->dir, $res);
		$css = STR::replace($css, $res, $dst);

		FSO::copy($res, $dst);
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
 // currently not in use
	$ful = APP::file($this->cms); if (! $ful) return false;
	return file_get_contents($ful);
}

// ***********************************************************
private function getFiles() {
	$arr = $lst = $chk = array();

	$sets = array( // assoc to avoid dups
		"default" => "default",
		 SSHEET   =>  SSHEET,
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
	return VEC::sort($lst); // sort prior to usage
}

// ***********************************************************
// auxilliary private functions
// ***********************************************************
private function compress($css) {
	$css = PRG::clrComments($css);
	$css = PRG::clrBlanks($css);
	$arr = str_split(":;,{()}-+"); // syntax chars

	foreach ($arr as $chr) {
		$css = STR::replace($css, "$chr ", $chr);
		$css = STR::replace($css, " $chr", $chr);
	}
	return trim($css);
}

// ***********************************************************
// fix url issues
// ***********************************************************
private function fix($css) {
	$css = $this->cleanUrls($css, 'url("', '"');
	return $css;
}

private function cleanUrls($css, $sep1, $sep2) {
	$css = STR::replace($css, "'", '"');
	$arr = STR::find($css, $sep1, $sep2);
	$cms = basename(FBK_DIR);

	foreach ($arr as $fil) {
		$ful = APP::url($fil);
		$css = STR::replace($css, $fil, $ful);
	}
	return $css;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
