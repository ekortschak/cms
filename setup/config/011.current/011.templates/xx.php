<?php

incCls("menus/buttons.php");

// ***********************************************************
$nav = new buttons("tpl", "T", __DIR__);
$nav->add("L", "doLayouts");
$nav->add("T", "doTemplates");
$nav->add("C", "doConfig");
$nav->add("B", "doButtons");
$nav->show();

?>
