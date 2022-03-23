<?php

$dir = FSO::mySep(__DIR__);
$ico = "core/icons/buttons";

// ***********************************************************
incCls("menus/buttons.php");
// ***********************************************************
$nav = new buttons("users", "E", $dir);
$nav->add("A", "doAdd");
$nav->add("E", "doEdit");
$nav->add("D", "doDrop");
$nav->show();

$nav->showContent();

?>
