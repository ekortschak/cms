<?php

incCls("menus/buttons.php");

// ***********************************************************
$nav = new buttons("users", "E", __DIR__);
$nav->add("A", "doAdd");
$nav->add("E", "doEdit");
$nav->add("D", "doDrop");
$nav->show();

?>
