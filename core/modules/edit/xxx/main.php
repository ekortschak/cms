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
$nav = new buttons("xedit", "S", __DIR__);
$nav->add("S", "doSearch");
$nav->add("R", "doRename", "rename");
$nav->space();
$nav->add("N", "doNums");
$nav->add("Q", "doEntities");
$nav->space();
$nav->add("T", "doTidy");
$nav->show();

?>
