<?php

incCls("menus/buttons.php");

// ***********************************************************
$nav = new buttons("dic", "S", __DIR__);
$nav->add("S", "doSearch");
$nav->add("E", "doEdit");
$nav->add("O", "doOpts");
$nav->show();

$nav->showContent();

?>
