<?php

// ***********************************************************
// check login
// ***********************************************************

// ***********************************************************
// set missing constants navigation parms
// ***********************************************************
CFG::read("design/config/defaults.ini");
PGE::init();

// ***********************************************************
// define display mode
// ***********************************************************
$mod = ENV::getParm("dmode", EDITING);
$lyt = LAYOUT;

$tpl = APP::file("design/layout/$lyt/$mod.tpl"); if (! $tpl)
$tpl = APP::file("design/layout/default/$mod.tpl");

// ***********************************************************
// read page file system - if needed
// ***********************************************************
if ($mod != "preview") {
	incCls("menus/PFS.php");

	PFS::init();
	LOG::lapse("pfs done");
}
else {
	LOG::lapse("pfs skipped");
}

// ***********************************************************
// show page
// ***********************************************************
$htm = new page();
$htm->read($tpl);
$htm->set("title", PRJ_TITLE);
$htm->setModules();
$htm->show();

?>
