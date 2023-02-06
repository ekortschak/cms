<?php

if (! FS_ADMIN) {
	incMod("stop.php");
	return;
}

incCls("editor/saveTab.php");
incCls("menus/buttons.php");

// ***********************************************************
// react to previous commands
// ***********************************************************
$obj = new saveTab();

// ***********************************************************
$nav = new buttons("tab", "P", __DIR__);
// ***********************************************************
$nav->add("T", "doTabs");
$nav->add("S", "doSort");
$nav->add("P", "doProps");
$nav->add("G", "doPics");
$nav->show();

?>
