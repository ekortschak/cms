<?php

incCls("menus/buttons.php");

$dir = APP::dir(__DIR__);

$nav = new buttons("const", "S", $dir);
$nav->add("S", "doSite");
$nav->add("X", "doMods");
$nav->add("D", "doDbs");
$nav->add("M", "doMail");
$nav->add("F", "doFtp");
$nav->show();

$nav->showContent();

?>
