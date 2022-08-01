<?php

if (! FS_ADMIN) return;

// ***********************************************************
$loc = PFS::getLoc();
$dir = APP::dir(__DIR__);

// ***********************************************************
// show content
// ***********************************************************
incCls("menus/buttons.php");

$nav = new buttons("tab", "P", $dir);
$nav->add("T", "doTabs");
$nav->add("S", "doSort");
$nav->add("P", "doProps");
$nav->add("G", "doPics");
$nav->show();

$nav->showContent();

?>
