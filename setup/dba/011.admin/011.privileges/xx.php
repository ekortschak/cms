<?php

incCls("menus/buttons.php");

// ***********************************************************
$nav = new buttons("prvs", "T", __DIR__);
$nav->add("M", "doMembers");
$nav->add("T", "doTables");
$nav->add("F", "doFields");
$nav->show();

?>
