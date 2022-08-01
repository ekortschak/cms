<?php

incCls("menus/buttons.php");
$dir = FSO::mySep(__DIR__);

// ***********************************************************
HTM::tag("Replicator", "h3");
// ***********************************************************
$nav = new buttons("xfer", "B", $dir);

$nav->add("B", "doBackup");
$nav->add("R", "doRestore");
$nav->add("U", "syncUp");
$nav->add("I", "doSingle");
$nav->add("S", "doStatic");
$nav->add("D", "syncDown");
$nav->add("V", "syncCms");

$nav->show();

// ***********************************************************
// show content
// ***********************************************************
$nav->showContent();

?>
