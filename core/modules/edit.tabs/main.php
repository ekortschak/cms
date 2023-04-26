<?php

if (! FS_ADMIN) {
	incMod("stop.php");
	return;
}

incCls("menus/buttons.php");

// ***********************************************************
$nav = new buttons("tab", "P", __DIR__);
// ***********************************************************
$nav->add("T", "doTabs");
$nav->add("A", "doAdd", "add");
$nav->add("S", "doSort");
$nav->add("P", "doProps");
$nav->add("X", "doDrop", "drop");
$nav->add("G", "doPics");
$nav->show();

?>
