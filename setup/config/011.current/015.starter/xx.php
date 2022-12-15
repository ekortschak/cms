<?php

$dir = FSO::mySep(__DIR__);
$ico = "core/icons/buttons";

// ***********************************************************
incCls("menus/buttons.php");
// ***********************************************************
$nav = new buttons("starter", "A", $dir);
$nav->add("A", "doAdd");
$nav->add("D", "doDrop");
$nav->show();

$nav->showContent();

?>
