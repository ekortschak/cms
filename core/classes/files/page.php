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
$htm->read("LOC_LAY/LAYOUT/main.tpl");
$htm->setModules();
$htm->show();

*/

incCls("files/iniTab.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class page extends tpl {
	private $mod = array("app", "zzz");	// array of modules called by layout and defined by modules/*/main.php

function __construct() {
	parent::__construct();
}

public function read($tpl = "LOC_LAY/LAYOUT/view.tpl") {
	$tpl = APP::file($tpl); if (! $tpl)
	$tpl = APP::file("LOC_LAY/default/main.tpl");

	parent::read($tpl);
}

// ***********************************************************
// handling page modules
// ***********************************************************
public function setModules() {
	$arr = $this->findModules(); $hld = array();

	foreach ($arr as $mod => $idx) {
		$idx = "app"; if (STR::begins($mod, "zzz.")) $idx = "zzz";
		$this->addModule($mod, $idx);
	}
}

private function getModules() {
	$app = VEC::get($this->mod, "app", array());
	$zzz = VEC::get($this->mod, "zzz", array());
	return $app + $zzz;
}

private function addModule($mod, $idx) {
	$ful = FSO::join(LOC_MOD, $mod, "main.php");
	$ful = APP::file($ful);
	$this->mod[$idx][$mod] = $ful;
}

private function findModules() {
	$tpl = parent::gc();
	$out = STR::find($tpl, "<!MOD:", "!>");
	return $out;
}

// ***********************************************************
// show page
// ***********************************************************
public function show($sec = "main") {
	$out = $this->gc($sec);

	if (CUR_DEST != "csv") {
		echo $out; return;
	}
	incCls("server/download.php");
	$srv = new download();
	$srv->csv("x.csv", $out);
}

// ***********************************************************
public function gc($sec = "main") {
    $htm = $this->getSection($sec); if (! $htm) return "";
    $arr = $this->getModules();

	foreach ($arr as $key => $fil) { // fill in modules
		$mod = "<!MOD:$key!>"; if (! STR::contains($htm, $mod)) continue;
		$val = APP::gcFile($fil);

		$htm = str_ireplace($mod, "$val\n", $htm);
	}
	$htm = $this->solveLinks($htm, 'src="');
	$htm = $this->solveLinks($htm, "src='");
	$htm = $this->solveLinks($htm, 'href="');
	$htm = $this->solveLinks($htm, "href='");

	$htm = $this->cleanChars($htm);
	$htm = $this->unescape($htm);

	$htm = STR::replace($htm, "ANCHOR", ANCHOR);
	return STR::dropSpaces($htm);
}

// ***********************************************************
// resolve file references and constants
// ***********************************************************
private function solveLinks($htm, $sep) {
	$arr = STR::find($htm, $sep, str_split("'\"?"));

	foreach ($arr as $fil) {
		$url = $this->makeUrl($fil); if (! $url) continue;
		$htm = STR::replace($htm, $sep.$fil, $sep.$url);
	}
	return $htm;
}

// ***********************************************************
public static function makeUrl($fso) { // convert file to url
	if (FSO::isUrl($fso)) return ""; if (! $fso) return "";

	if (STR::begins($fso, "./")) { // e.g. local pics
		$fil = STR::after($fso, "./");
		return FSO::join(PGE::$dir, $fil);
	}
	return APP::url($fso);
}

// ***********************************************************
private function unescape($code) {
	$out = STR::replace($code, "<|", "<!");
	return $out;
}

// ***********************************************************
private function cleanChars($code) {
	if (CUR_LANG != "de") return $code;

	$out = STR::replace($code, "(CR)", "&copy;");

	$fnd = array(
		"ä" => "&auml;", "Ä" => "&Auml;", "ß" => "&szlig;",
		"ö" => "&ouml;", "Ö" => "&Ouml;",
		"ü" => "&uuml;", "Ü" => "&Uuml;",
	);
	foreach ($fnd as $key => $val) {
		$out = str_replace($key, $val, $out);
	}
	return $out;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
