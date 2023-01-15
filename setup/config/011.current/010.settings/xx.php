<?php

incCls("menus/buttons.php");

// ***********************************************************
$nav = new buttons("const", "C", __DIR__);
// ***********************************************************
$nav->add("C", "doConfig");
$nav->add("X", "doMods");
$nav->add("D", "doDbs");
$nav->add("M", "doMail");
$nav->add("F", "doFtp");
$nav->show();

?>
