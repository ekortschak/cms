<?php

incCls("menus/buttons.php");

HTW::xtag("replicator", "div class='h3'");
DBG::file(__FILE__);

// ***********************************************************
$nav = new buttons("xfer", "B", __DIR__);
// ***********************************************************
$nav->add("B", "doBackup");
$nav->add("U", "syncUp",   "upload");
$nav->space();
$nav->add("R", "doRestore");
$nav->add("D", "syncDown", "download");
$nav->space();
$nav->add("I", "doSingle", "pdf");
#$nav->add("S", "doStatic", "static");
$nav->space();
$nav->add("V", "syncCms");
$nav->show();

?>
