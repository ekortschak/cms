<?php

/* ***********************************************************
// INFO
// ***********************************************************
used to convert a topic to a single document

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("xsite/bind.php");

$buk = new bind();
$buk->read($dir);
$buk->exec($dst, $opt);
*/

incCls("xsite/toctool.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class bind extends objects {
	private $dat = array();

function __construct() {}

// ***********************************************************
// read all selected files
// ***********************************************************
public function read($dir) {
	$this->dat = PFS::items($dir);
}

public function exec($dst, $mod) {
	$htm = $this->content($mod);
	$htm = $this->xform($htm, $mod);
	$htm = CFG::apply($htm);

	switch ($dst) {
		case "fil": $this->write($htm, $mod); return $htm;
		case "pdf": $this->writePdf($htm);    return $htm;
	}
	echo $htm;

	if ($mod == "toc") $this->writeIni();
}

// ***********************************************************
// handling doc pages, toc and footnotes
// ***********************************************************
private function content($mod) {
	$doc = $this->incFile("doc"); $cnt = 1;
	ob_start();

	foreach($this->dat as $inf) {
		$dir = $inf["fpath"]; if (! is_dir($dir)) continue;
		$kap = $inf["chnum"];
		PGE::load($dir);

		switch ($mod) {
			case "toc":	PGE::addToc(); break;
			default:    include $doc;
		}
	}
	return ob_get_clean();
}

// ***********************************************************
// transforming output as needed in a book
// ***********************************************************
private function xform($htm, $mod) {
	incCls("xsite/prn.php");

	$prn = new prn();
	if ($mod == "toc") return $prn->toc();

	$htm = $prn->stripNotes($htm);
	$htm = $prn->stripSections($htm);
	$idx = $prn->fnotes();
	return $toc.$htm.$idx;
}

// ***********************************************************
// writing output to file
// ***********************************************************
private function write($doc, $mod) {
	$tpl = FSO::join(LOC_LAY, LAYOUT);
	$tpl = APP::fbkFile($tpl, "blank.tpl");
	$css = APP::fbkFile("static", "cms.css");
	$tpl = APP::read($tpl);
	$css = APP::read($css);

	$htm = STR::replace($tpl, "**STYLES**", $css);
	$htm = STR::replace($htm, "**CONTENT**", $doc);

	$dir = FSO::join(APP_DIR, "print");
	$tit = PGE::title(TAB_HOME);
	$fil = "$dir/$tit.$mod.htm";

	$erg = APP::write($fil, $htm); if (! $erg) return;
	echo "File written to: $fil";
}

// ***********************************************************
// writing output to pdf
// ***********************************************************
private function writePdf($doc) {
	incCls("xsite/tcpdf.php");

	$pdf = new mypdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, "UTF-8", false);
	$pdf->makePDF($doc);
}

// ***********************************************************
// writing output to toc.ini
// ***********************************************************
private function writeIni() {
	$toc = new toctool();
	$toc->clearSec("toc");

	$arr = PGE::getToc();

	foreach ($arr as $num => $cap) {
		$toc->set("toc.$num", $pge);
	}
	$toc->save();
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function incFile($opt) {
	$fil = FSO::join("LOC_MOD", "xsite", "$opt.php");
	return APP::file($fil);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
