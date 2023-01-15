<?php

incCls("menus/buttons.php");

// ***********************************************************
$nav = new buttons("dbs", "P", __DIR__);
// ***********************************************************
$nav->add("A", "doAdd",    "add");
$nav->add("R", "doRen",    "rename");
$nav->add("D", "doDrop",   "drop");
$nav->add("P", "doFields", "props");
#$nav->add("U", "doPerms");
$nav->show();

?>

