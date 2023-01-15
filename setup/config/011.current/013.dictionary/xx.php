<?php

incCls("menus/buttons.php");

// ***********************************************************
$nav = new buttons("dic", "S", __DIR__);
// ***********************************************************
$nav->add("S", "doSearch", "search");
$nav->add("A", "doAdd",    "add");
$nav->add("E", "doEdit",   "edit");
$nav->add("D", "doDrop",   "drop");
$nav->add("O", "doOpts");
$nav->show();

?>
