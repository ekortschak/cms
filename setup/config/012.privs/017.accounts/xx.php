<?php

incCls("menus/buttons.php");

// ***********************************************************
$nav = new buttons("accounts", "P", __DIR__);
$nav->add("A", "doAdd");
$nav->add("P", "doProps");
$nav->add("D", "doDrop");
$nav->show();

$nav->showContent();

?>
