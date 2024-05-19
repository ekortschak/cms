<?php

DBG::file(__FILE__);

// ***********************************************************
// check if applicable
// ***********************************************************
if (! FS_ADMIN) {
	return APP::mod("msgs/stop");
}

// ***********************************************************
incCls("menus/buttons.php");
// ***********************************************************
$nav = new buttons("tab", "P", __DIR__);

$nav->add("T", "doTab");
$nav->add("S", "doSort");
$nav->blank();
$nav->add("P", "doProps");
$nav->add("G", "doPics");
$nav->space();
$nav->link("V", HTM::icon("buttons/view.png"), "?vmode=view");
$nav->show();

?>
