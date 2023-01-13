<?php

ENV::set("lookup", false);

incCls("menus/buttons.php");

// ***********************************************************
$nav = new buttons("lup", "E", __DIR__);
$nav->add("A", "doAdd");
$nav->add("E", "doEdit", "edit");
$nav->add("D", "doDrop");
$nav->add("I", "doInject");
$nav->show();

$nav->showContent();

?>
