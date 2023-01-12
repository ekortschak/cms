<?php

$dir = FSO::mySep(__DIR__);

// ***********************************************************
incCls("menus/buttons.php");
// ***********************************************************
$nav = new buttons("dbbkp", "B", $dir);
$nav->add("B", "doBackup");
$nav->add("S", "doRestore");
$nav->show();

$nav->showContent();

?>

