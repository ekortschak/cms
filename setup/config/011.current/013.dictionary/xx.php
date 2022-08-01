<?php

incCls("menus/buttons.php");

$dir = APP::dir(__DIR__);

$nav = new buttons("dic", "D", $dir);
$nav->add("D", "doDic");
$nav->add("S", "doSearch");
$nav->add("O", "doOpts");
$nav->show();

$nav->showContent();

?>
