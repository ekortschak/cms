<?php

incCls("menus/buttons.php");

$dir = APP::dir(__DIR__);

$nav = new buttons("tpl", "L", $dir);
$nav->add("L", "doLayout");
$nav->add("T", "doObjects");
$nav->show();

$nav->showContent();

?>
