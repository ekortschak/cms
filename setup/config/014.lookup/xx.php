<?php

incCls("menus/buttons.php");

$dir = APP::dir(__DIR__);

$nav = new buttons("dic", "E", $dir);
$nav->add("E", "doEdit", "edit");
$nav->add("I", "doInject");
$nav->show();

$nav->showContent();

?>
