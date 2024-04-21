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
	protected $mod = array("app", "zzz");	// array of modules called by layout and defined by modules/*/main.php

function __construct() {
	parent::__construct();
}

public function read($tpl = "view") {
	$tpl = APP::layout($tpl); if (! $tpl)
    $tpl = APP::layout("stop");

	parent::read($tpl);
}

// ***********************************************************
// handling page modules
// ***********************************************************
public function setModules() {
	$tpl = parent::gc();
	$arr = STR::find($tpl, "<!MOD:", "!>");

	foreach ($arr as $mod => $idx) {
		$idx = "app"; if (STR::begins($mod, "zzz/")) $idx = "zzz";
		$this->addModule($mod, $idx);
	}
}

protected function getModules() {
	$app = VEC::get($this->mod, "app", array());
	$zzz = VEC::get($this->mod, "zzz", array());
	return $app + $zzz;
}

// ***********************************************************
protected function addModule($mod, $idx) {
	$ful = $this->findModule($mod); if (! $ful) return;
	$this->mod[$idx][$mod] = $ful;
}

protected function findModule($mod) {
	$dir = FSO::join(LOC_MOD, $mod);    if (APP::file($dir)) return $dir;
	$fil = FSO::join($dir, "main.php"); if (APP::file($fil)) return $fil;
	return false;
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
		$mod = "<!MOD:$key!>"; if (STR::misses($htm, $mod)) continue;
		$val = APP::gcFile($fil);
		$htm = STR::replace($htm, $mod, "$val\n", false);
	}
	return $this->cleanUp($htm);
}

// ***********************************************************
// resolve file references
// ***********************************************************
protected function cleanUp($htm) {
	$htm = $this->solveLinks($htm, "src");
	$htm = $this->solveLinks($htm, "href");

	$htm = STR::replace($htm, "CUR_PAGE", PGE::$dir);
	$htm = STR::replace($htm, "<|", "<!");
	$htm = CFG::unescape($htm);

	return STR::dropSpaces($htm);
}

// ***********************************************************
protected function solveLinks($htm, $atr) {
	$htm = PRG::replace($htm, "$atr(\s?)=(\s?)(['\"]+)(.*?)\"", "$atr=\"$4\"");
	$arr = STR::find($htm, "$atr=\"", str_split("'\"?"));

	foreach ($arr as $fil) {
		$url = APP::url($fil); if (! $url) continue;
		$htm = STR::replace($htm, $fil, $url);
	}
	return $htm;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
