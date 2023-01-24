<?php

if (! FS_ADMIN) {
	incMod("stop.php");
	return;
}

incCls("editor/saveMenu.php");
incCls("menus/buttons.php");

// ***********************************************************
// react to previous commands
// ***********************************************************
$obj = new saveMenu();

// ***********************************************************
// show title
// ***********************************************************
$loc = PFS::getLoc();
$tit = PGE::getTitle($loc);

HTW::tag($tit, "h3");

// ***********************************************************
$nav = new buttons("menu", "F", __DIR__);
// ***********************************************************
$nav->add("D", "doFolders");
$nav->add("F", "doFiles");
$nav->add("A", "doUpload", "upload");
$nav->add("P", "doProps",  "props");
$nav->add("R", "doSort",   "sort");
$nav->add("S", "doStatic", "static");
$nav->add("U", "doUser");
$nav->add("C", "doClip",   "clip");
$nav->show();

?>
