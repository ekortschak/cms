<?php

incCls("menus/buttons.php");

// ***********************************************************
$nav = new buttons("sfchk", "H", __DIR__);
$nav->add("H", "doRescue");
$nav->show();

?>

