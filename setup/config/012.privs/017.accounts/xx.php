<?php

$dir = FSO::mySep(__DIR__);

// ***********************************************************
incCls("menus/buttons.php");
// ***********************************************************
$nav = new buttons("accounts", "P", $dir);
$nav->add("A", "doAdd");
$nav->add("P", "doProps");
$nav->add("D", "doDrop");
$nav->show();

$nav->showContent();

?>
