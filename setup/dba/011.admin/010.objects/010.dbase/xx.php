<?php

incCls("menus/buttons.php");

// ***********************************************************
$nav = new buttons("dbs", "P", __DIR__);
$nav->add("A", "doAdd");
$nav->add("R", "doRen");
$nav->add("D", "doDrop");
$nav->add("P", "doFields", "props");
#$nav->add("U", "doPerms");
$nav->show();

$nav->showContent();

?>

