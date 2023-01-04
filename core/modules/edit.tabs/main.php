<?php

if (! FS_ADMIN) {
	incMod("stop.php");
	return;
}

incCls("menus/buttons.php");

// ***********************************************************
// show title
// ***********************************************************
$loc = PFS::getLoc();
$tit = PGE::getTitle($loc);
$dir = APP::dir(__DIR__);

HTW::tag("edit.tab", "h3");

// ***********************************************************
// show options
// ***********************************************************
$nav = new buttons("tab", "P", $dir);

$nav->add("T", "doTabs");
$nav->add("S", "doSort");
$nav->add("P", "doProps");
$nav->add("G", "doPics");
$nav->show();

$nav->showContent();

?>
