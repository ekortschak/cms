<?php

if (! FS_ADMIN) {
	incMod("stop.php");
	return;
}

incCls("menus/buttons.php");

// ***********************************************************
// show title
// ***********************************************************
$dir = FSO::mySep(__DIR__);

HTW::xtag("xedit", "h3");

// ***********************************************************
// show options
// ***********************************************************
$nav = new buttons("xedit", "S", $dir);

$nav->add("S", "doSearch");
$nav->add("R", "doRename");
$nav->add("N", "doNums");
$nav->add("T", "doTidy");
$nav->addSpace(5);
$nav->add("X", "doXLate");
$nav->add("F", "doXRef");
$nav->show();

$nav->showContent();

?>
