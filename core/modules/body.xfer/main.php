<?php

incCls("menus/buttons.php");

// ***********************************************************
HTW::xtag("replicator", "h3");
// ***********************************************************
$nav = new buttons("xfer", "B", __DIR__);

$nav->add("B", "doBackup");
$nav->add("U", "syncUp");
$nav->add("C", "curlUp");
$nav->add("R", "doRestore");
$nav->add("D", "syncDown");
$nav->add("I", "doSingle");
$nav->add("S", "doStatic");
$nav->add("V", "syncCms");
$nav->show();

?>
