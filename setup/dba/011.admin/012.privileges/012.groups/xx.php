<?php

$dir = FSO::mySep(__DIR__);

// ***********************************************************
incCls("menus/buttons.php");
// ***********************************************************
$nav = new buttons("groups", "A", $dir);
$nav->add("A", "doAdd");
$nav->add("D", "doDrop");
$nav->show();

$nav->showContent();

?>