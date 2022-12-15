<?php

incCls("menus/buttons.php");

$dir = APP::dir(__DIR__);

$nav = new buttons("dic", "S", $dir);
$nav->add("S", "doSearch");
$nav->add("E", "doEdit");
$nav->add("O", "doOpts");
$nav->show();

$nav->showContent();

?>
