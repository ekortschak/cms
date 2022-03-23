<?php

incCls("menus/buttons.php");

$dir = APP::dir(__DIR__);

$nav = new buttons("const", "S", $dir);
$nav->add("S", "doSite");
$nav->add("M", "doMail");
$nav->add("D", "doDbs");
$nav->add("F", "doFtp");
$nav->add("X", "doMods");
$nav->show();

HTM::tag("mod.vars");

$nav->showContent();

?>
