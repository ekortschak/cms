<?php

// ***********************************************************
// set missing constants navigation parms
// ***********************************************************
CFG::read("LOC_CFG/defaults.ini");
CFG::read("LOC_CFG/constants.ini");
PGE::init();

// ***********************************************************
// define display mode
// ***********************************************************
$mod = ENV::getParm("dmode", EDITING);

$tpl = APP::file("LOC_LAY/LAYOUT/$mod.tpl");  if (! $tpl)
$tpl = APP::file("LOC_LAY/default/$mod.tpl"); if (! $tpl)
$tpl = APP::file("LOC_LAY/default/stop.tpl");

// ***********************************************************
// read page file system - if needed
// ***********************************************************
incCls("menus/PFS.php");
PFS::init();

// ***********************************************************
// show page
// ***********************************************************
$htm = new page();
$htm->read($tpl);
$htm->set("layout", "$mod.tpl");
$htm->set("title", PRJ_TITLE);
$htm->setModules();
$htm->show();

?>
