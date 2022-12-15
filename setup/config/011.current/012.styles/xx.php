<?php

incCls("menus/buttons.php");

$dir = APP::dir(__DIR__);

$nav = new buttons("css", "P", $dir);
$nav->add("P", "doPreview");
$nav->add("K", "doConsts");
$nav->add("C", "doColors");
$nav->add("F", "doFiles");
$nav->add("S", "doStatic");
$nav->show();

$nav->showContent();

?>
