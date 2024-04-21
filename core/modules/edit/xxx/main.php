<?php

DBG::file(__FILE__);

// ***********************************************************
// check if applicable
// ***********************************************************
if (! FS_ADMIN) {
	return APP::mod("msgs/stop");
}

HTW::xtag("xedit", "div class='h3'");

// ***********************************************************
incCls("menus/buttons.php");
// ***********************************************************
$nav = new buttons("xedit", "S", __DIR__);
$nav->add("S", "doSearch");
$nav->add("R", "doRename", "rename");
$nav->add("N", "doNums");
$nav->space();
$nav->add("T", "doTidy");
$nav->show();

?>
