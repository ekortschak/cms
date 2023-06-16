<?php

PGE::init();

// ***********************************************************
// define display mode
// ***********************************************************
$mod = ENV::getParm("dmode", VMODE);

$tpl = APP::file("LOC_LAY/LAYOUT/$mod.tpl");  if (! $tpl)
$tpl = APP::file("LOC_LAY/default/$mod.tpl"); if (! $tpl)
$tpl = APP::file("LOC_LAY/default/stop.tpl");

// ***********************************************************
// react to previous editing
// ***********************************************************
incFnc("load.save.php");

// ***********************************************************
// read page file system - if needed
// ***********************************************************
incCls("menus/PFS.php");   // load menu builder
PFS::init();

// ***********************************************************
// show page
// ***********************************************************
incCls("files/page.php");  // load page builder

$htm = new page();
$htm->read($tpl);
$htm->set("layout", "$mod.tpl");
$htm->set("title", PRJ_TITLE);
$htm->setModules();
$htm->show();

?>
