<?php

incCls("menus/buttons.php");

// ***********************************************************
$nav = new buttons("dbbkp", "B", __DIR__);
// ***********************************************************
$nav->add("B", "doBackup");
$nav->add("S", "doRestore");
$nav->show();

?>

