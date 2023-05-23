<?php
/* ***********************************************************
// INFO
// ***********************************************************
used to handle project setup tasks

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("input/cmsSetup.php");

$obj = new cmsSetup();
*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class cmsSetup {

function __construct() {}

// ***********************************************************
// methods
// ***********************************************************
public function reconfig($file, $prj) {
	$ver = CFG::getVal("config", "app.version", "?");

	$txt = APP::read($file);
	$txt = STR::replace($txt, "*project*", $prj);
	$txt = STR::replace($txt, "*version*", $ver);
	APP::write($file, $txt);
}

public function getTabIni($prj, $tpc) {
	$txt = APP::read("design/setup/tab.ini");
	$txt = STR::replace($txt, "*project*", $prj);
	$txt = STR::replace($txt, "*home*", $tpc);
	return $txt;
}

public function getIni($uid) {
	$txt = APP::read("design/setup/page.ini");
	$txt = STR::replace($txt, "*uid*", $uid);
	return $txt;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
