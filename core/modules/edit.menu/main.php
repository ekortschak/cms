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
$dir = FSO::mySep(__DIR__);

HTW::tag($tit, "h3");

// ***********************************************************
// show options
// ***********************************************************
$nav = new buttons("menu", "F", $dir);

$nav->add("D", "doFolders");
$nav->add("F", "doFiles");
$nav->add("A", "doUpload");
$nav->add("P", "doProps", "props");
$nav->add("R", "doSort");
$nav->add("S", "doStatic");
$nav->add("U", "doUser");
$nav->add("C", "doClip");
$nav->show();

$nav->showContent();

?>
