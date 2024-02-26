<?php

CFG::setDest(VMODE);

// ***********************************************************
// react to previous editing
// ***********************************************************
APP::inc("core/include", "load.save.php");
APP::inc("core/include", "load.app.php");

PGE::init();

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
$htm->read(VMODE);
$htm->set("tpl", "$mod.tpl");
$htm->set("title", PRJ_TITLE);
$htm->setModules();
$htm->show();

?>
