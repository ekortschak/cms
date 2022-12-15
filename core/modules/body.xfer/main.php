<?php

incCls("menus/buttons.php");
$dir = FSO::mySep(__DIR__);

// ***********************************************************
HTM::tag("replicator", "h3");
// ***********************************************************
$nav = new buttons("xfer", "B", $dir);

$nav->add("B", "doBackup");
$nav->add("U", "syncUp");
$nav->add("R", "doRestore");
$nav->add("D", "syncDown");
$nav->add("I", "doSingle");
$nav->add("S", "doStatic");
$nav->add("V", "syncCms");

$nav->show();

// ***********************************************************
// show content
// ***********************************************************
$nav->showContent();

?>
