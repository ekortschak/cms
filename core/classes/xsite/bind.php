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

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class bind extends objects {
	private $dat = array();

function __construct() {
	$fil = FSO::join(TAB_HOME, "bind.ini");
	$this->readIni($fil);
}

// ***********************************************************
// read all selected files
// ***********************************************************
public function read($dir) {
	$this->dat = PFS::items($dir);
}

public function exec($dst, $opt) {
	$fnc = "get".ucfirst($opt); // ToC or Doc
	$htm = $this->$fnc($dst);

	switch ($dst) {
		case "fil": $this->write($htm, $opt); return $htm;
		case "pdf": $this->writePdf($htm);    return $htm;
	}
	echo $htm;
}

// ***********************************************************
// handling doc pages and footnotes
// ***********************************************************
private function getDoc() {
	$xxx = ob_start(); $this->doContent(); $this->doNotes();
	return ob_get_clean();
}

// ***********************************************************
private function doContent() {
	$loc = FSO::join("LOC_MOD", "xsite");

	foreach($this->dat as $inf) {
		PGE::load($inf["fpath"]);
		APP::inc($loc, "doc.php");
	}
}
private function doNotes() {
	$its = PRN::notes(); if (! $its) return "";

	$tpl = new tpl();
	$tpl->load("xsite/footnote.tpl");
	$tpl->set("items", implode("<br>\n", $its));
	$tpl->show();
}

// ***********************************************************
// handling ToC
// ***********************************************************
private function getToc() {
	$xxx = ob_start(); $this->doToC();
	return ob_get_clean();
}

// ***********************************************************
private function doToC() {
	$lst = array(); $cnt = 1;

	$tpl = new tpl();
	$tpl->load("xsite/toc.tpl");

	foreach($this->dat as $dir => $nam) {
		PGE::load($dir);
		PGE::loadPFS($dir);

		$lev = PGE::level();
		$sec = $this->getSec($lev); if (! $sec) continue;

		$key = $tpl->set("cap", $this->getTitle());
		$key = $tpl->set("page", $cnt++);
		$val = $tpl->gc("toc.$sec");

		$lst[$key] = $val;
	}
	$tpl->set("items", implode("\n", $lst));

	return $tpl->gc();
}

// ***********************************************************
private function getSec($lev) {
	if ($lev == 0) return "lev0";
	if ($lev == 1) return "lev1";
	return "levx";
}

private function getTitle() {
	$typ = $this->get("bind.title");

	if ($typ == "pfs.chap") return PGE::get($typ);
	return PGE::title();
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
} // END OF CLASS
// ***********************************************************
?>
