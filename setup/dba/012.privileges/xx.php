<?php

$dir = FSO::mySep(__DIR__);

// ***********************************************************
incCls("menus/buttons.php");
// ***********************************************************
$nav = new buttons("prvs", "T", $dir);
$nav->add("M", "doMembers");
$nav->add("T", "doTables");
$nav->add("F", "doFields");
$nav->show();

$nav->showContent();

?>
