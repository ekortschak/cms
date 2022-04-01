<?php

incCls("menus/buttons.php");

$dir = APP::dir(__DIR__);

$nav = new buttons("css", "K", $dir);
$nav->add("K", "doConsts");
$nav->add("C", "doColors");
$nav->add("F", "doFiles");
$nav->add("S", "doCSS");
$nav->show();

$nav->showContent();

?>
