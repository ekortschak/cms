<?php

incCls("menus/buttons.php");

// ***********************************************************
$nav = new buttons("groups", "A", __DIR__);
$nav->add("A", "doAdd");
$nav->add("D", "doDrop");
$nav->show();

$nav->showContent();

?>
