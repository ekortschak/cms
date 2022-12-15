<?php

ENV::set("lookup", false);

incCls("menus/buttons.php");

$dir = APP::dir(__DIR__);

$nav = new buttons("lup", "E", $dir);
$nav->add("A", "doAdd");
$nav->add("E", "doEdit", "edit");
$nav->add("D", "doDrop");
$nav->add("I", "doInject");
$nav->show();

$nav->showContent();

?>
