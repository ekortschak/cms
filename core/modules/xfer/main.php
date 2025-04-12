<?php

DBG::file(__FILE__);

incCls("menus/buttons.php");

// ***********************************************************
$nav = new buttons("xfer", "B", __DIR__);
// ***********************************************************
$nav->add("B", "doBackup");
$nav->add("U", "syncUp",   "upload");
$nav->space();
$nav->add("R", "doRestore");
$nav->add("D", "syncDown", "download");
$nav->space();
#$nav->add("S", "doStatic", "static");
$nav->space();
$nav->add("V", "syncCms");
$nav->show();

?>
