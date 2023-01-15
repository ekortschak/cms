<?php

if (! FS_ADMIN) {
	incMod("stop.php");
	return;
}

incCls("menus/buttons.php");

HTW::xtag("xedit", "h3");

// ***********************************************************
$nav = new buttons("xedit", "S", __DIR__);
// ***********************************************************
$nav->add("S", "doSearch", "search");
$nav->add("R", "doRename", "rename");
$nav->add("N", "doNums");
$nav->add("T", "doTidy");
$nav->addSpace(5);
$nav->add("X", "doXLate");
$nav->add("F", "doXRef");
$nav->show();

?>
