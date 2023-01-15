<?php

incCls("menus/buttons.php");

// ***********************************************************
$nav = new buttons("tbls", "P", __DIR__);
// ***********************************************************
$nav->add("C", "doCopy",  "copy");
$nav->add("A", "doAdd",   "add");
$nav->add("P", "doProps", "props");
$nav->add("R", "doRen",   "rename");
$nav->add("S", "doSort",  "sort");
$nav->add("D", "doDrop",  "drop");
$nav->add("U", "doPerms");
$nav->show();

?>

