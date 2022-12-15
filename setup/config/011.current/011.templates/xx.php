<?php

incCls("menus/buttons.php");

$dir = APP::dir(__DIR__);

$nav = new buttons("tpl", "T", $dir);
$nav->add("L", "doLayouts");
$nav->add("T", "doTemplates");
$nav->add("C", "doConfig");
$nav->add("B", "doButtons");
$nav->show();

$nav->showContent();

?>
