<?php

incCls("menus/buttons.php");

$dir = APP::dir(__DIR__);

$nav = new buttons("const", "C", $dir);
$nav->add("C", "doConfig");
$nav->add("X", "doMods");
$nav->add("D", "doDbs");
$nav->add("M", "doMail");
$nav->add("F", "doFtp");
$nav->show();

$nav->showContent();

?>
