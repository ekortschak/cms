<?php

incCls("menus/buttons.php");

HTW::xtag("replicator", "h3");

// ***********************************************************
$nav = new buttons("xfer", "B", __DIR__);
// ***********************************************************
$nav->add("B", "doBackup");
$nav->add("U", "syncUp",   "upload");
$nav->add("R", "doRestore");
$nav->add("D", "syncDown", "download");
$nav->add("I", "doSingle", "pdf");
$nav->add("S", "doStatic", "static");
$nav->add("V", "syncCms");
$nav->show();

?>
