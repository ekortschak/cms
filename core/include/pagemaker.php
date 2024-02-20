<?php

PGE::init();
CFG::setDest(VMODE);

// ***********************************************************
// react to previous editing
// ***********************************************************
$fil = appFile("core/include/load.save.php");
include_once $fil;

// ***********************************************************
// read page file system - if needed
// ***********************************************************
incCls("menus/PFS.php");   // load menu builder
PFS::init();

// ***********************************************************
// supply app specific features
// ***********************************************************
$fil = appFile("core/include/load.app.php");
include_once $fil;

// ***********************************************************
// show page
// ***********************************************************
incCls("files/page.php");  // load page builder

$htm = new page();
$htm->read(VMODE);
$htm->set("tpl", "$mod.tpl");
$htm->set("title", PRJ_TITLE);
$htm->setModules();
$htm->show();

?>
