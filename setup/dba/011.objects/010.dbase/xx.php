<?php

$dir = FSO::mySep(__DIR__);
$ico = "core/icons/buttons";

// ***********************************************************
incCls("menus/buttons.php");
// ***********************************************************
$nav = new buttons("tbls", "P", $dir);
$nav->add("A", "doAdd");
$nav->add("R", "doRen");
$nav->add("D", "doDrop");
$nav->add("B", "doBackup");
$nav->add("S", "doRestore");
$nav->add("H", "doRescue");
$nav->add("P", "doFields", "props");
#$nav->add("U", "doPerms");
$nav->show();

$nav->showContent();

?>

