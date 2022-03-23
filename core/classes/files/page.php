<?php
/* ***********************************************************
// INFO
// ***********************************************************
used for handling page layouts

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("files/page.php");

$htm = new page();
$htm->read("design/layout/LAYOUT/main.tpl");
$htm->setModules();
$htm->show();

*/

incCls("files/iniTab.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class page extends tpl {
	private $blk = array();	// array of blocks defined by modules/*/main.php
	private $dir = "core/modules";

function __construct() {
	parent::__construct();
}

public function read($tpl = "design/layout/LAYOUT/view.tpl") {
	$tpl = KONST::insert($tpl);
	$tpl = APP::file($tpl); if (! $tpl)
	$tpl = APP::file("design/layout/default/main.tpl");

	parent::read($tpl);
}

// ***********************************************************
// handling page modules
// ***********************************************************
public function setModules() {
	$arr = $this->getModules();

	foreach ($arr as $mod => $sidx) {
		$ful = FSO::join($this->dir, $mod, "main.php");
		$ful = APP::file($ful);
		$this->blk[$mod] = $ful;
	}
}

private function getModules() {
	$tpl = parent::gc();
	$out = STR::find($tpl, "<!MOD:", "!>");
	asort($out);
	return $out;
}

// ***********************************************************
// show page
// ***********************************************************
public function show($sec = "main") {
	if (CUR_DEST == "csv") {
		incCls("server/download.php");
		$dwn = new download();
		$dwn->csv("x.csv", $this->gc());
		return;
	}
	echo $this->gc($sec);
}

// ***********************************************************
public function gc($sec = "main") {
    $htm = $this->getSection($sec); if (! $htm) return "";
	$xxx = $this->set("pginfo", $this->getHist());

#LOG::lapse("begin modules");

	foreach ($this->blk as $key => $fil) { // fill in blocks
		$mod = "<!MOD:$key!>"; if (! STR::contains($htm, $mod)) continue;
		$val = APP::getBlock($fil);

#LOG::lapse("mod $key");

		$htm = str_ireplace($mod, "$val\n", $htm);
	}
	$htm = $this->solveLinks($htm, 'src="');
	$htm = $this->solveLinks($htm, "src='");
	$htm = $this->solveLinks($htm, 'href="');
	$htm = $this->solveLinks($htm, "href='");

LOG::total();

	$htm = $this->cleanChars($htm);
	return STR::dropSpaces($htm);
}

// ***********************************************************
// resolve file references and constants
// ***********************************************************
private function solveLinks($htm, $sep) {
	$del = str_split("'\"?"); $lst = array();
	$arr = STR::find($htm, $sep, $del);

	foreach ($arr as $fil) {
		$url = APP::url($fil); if (! $url) continue;
		$htm = STR::replace($htm, $sep.$fil, $sep.$url);
	}
	return $htm;
}

private function cleanChars($code) {
	if (CUR_LANG != "de") return $code;

	$fnd = array(
		"ä" => "&auml;", "Ä" => "&Auml;", "ß" => "&szlig;",
		"ö" => "&ouml;", "Ö" => "&Ouml;",
		"ü" => "&uuml;", "Ü" => "&Uuml;",
	);
	foreach ($fnd as $key => $val) {
		$code = str_replace($key, $val, $code);
	}
	return $code;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
