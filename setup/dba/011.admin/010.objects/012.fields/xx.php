<?php

incCls("menus/buttons.php");

// ***********************************************************
$nav = new buttons("flds", "P", __DIR__);
$nav->add("C", "doCopy");
$nav->add("A", "doAdd");
$nav->add("E", "doEdit");
$nav->add("P", "doProps");
$nav->add("R", "doRen");
$nav->add("M", "doMove");
$nav->add("D", "doDrop");
$nav->show();

?>
