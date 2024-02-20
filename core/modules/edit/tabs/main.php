<?php

if (! FS_ADMIN) {
	return APP::mod("msgs/stop");
}

DBG::file(__FILE__);

// ***********************************************************
incCls("menus/buttons.php");
// ***********************************************************
$nav = new buttons("tab", "P", __DIR__);

$nav->add("T", "doTabs");
$nav->add("A", "doAdd",  "add");
$nav->add("X", "doDrop", "drop");
$nav->space();
$nav->add("S", "doSort");
$nav->add("P", "doProps");
$nav->space();
$nav->add("G", "doPics");
$nav->space();
$nav->link("V", HTM::icon("buttons/view.png"), "?vmode=view");
$nav->show();

?>
