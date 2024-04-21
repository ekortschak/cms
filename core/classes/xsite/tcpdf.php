<?php

define("TC_PDF", X_TOOLS."/tcpdf");

$pth = get_include_path();
$xxx = set_include_path($pth.PATH_SEPARATOR.TC_PDF);

// ***********************************************************
// load constants
// ***********************************************************
$cfg = FSO::join(__DIR__, "tcpdf_config.php");
require_once $cfg;

// load class
$fil = FSO::join(K_PATH_MAIN, "tcpdf.php");
require_once $fil;

// ***********************************************************
// create fonts (if necessary)
// ***********************************************************
APP::inc(__DIR__, "createfont.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class mypdf extends TCPDF {
	private $dat = array();

function __construct($orientation = 'P', $unit = 'mm', $format = 'A4', $unicode = true, $encoding = 'UTF-8', $diskcache = false, $pdfa = false) {
	parent::__construct($orientation, $unit, $format, $unicode, $encoding, $diskcache, $pdfa);

// set document information
	$this->setCreator(PDF_CREATOR);
	$this->setAuthor("www.glaubeistmehr.at");
	$this->setTitle("");
	$this->setSubject("");
	$this->setKeywords("");

// set default header data
	$this->setHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE." 001", PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
	$this->setFooterData(array(0, 64, 0), array(0, 64, 128));

// set header and footer fonts
	$this->setHeaderFont(Array(PDF_FONT_NAME_MAIN, "", PDF_FONT_SIZE_MAIN));
	$this->setFooterFont(Array(PDF_FONT_NAME_DATA, "", PDF_FONT_SIZE_DATA));

// set default monospaced font
	$this->setDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
	$this->setMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$this->setHeaderMargin(PDF_MARGIN_HEADER);
	$this->setFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
	$this->setAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
	$this->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Set font
	$this->setFontSubsetting(true);
	$this->setFont(MYFONT, "", 12, "", true);
}

// ***********************************************************
// write html to pdf
// ***********************************************************
public function makePDF($htm) {
#$html = <<<EOD$htm EOD;

	$this->AddPage();
	$this->writeHTMLCell(0, 0, "", "", $htm, 0, 1, 0, true, "", true);
	$this->Output("example_001.pdf", "I");
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
