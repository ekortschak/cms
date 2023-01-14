<?php

if (! FS_ADMIN) {
	incMod("stop.php");
	return;
}

incCls("editor/mnuEdit.php");
incCls("menus/buttons.php");

// ***********************************************************
// react to previous commands
// ***********************************************************
$obj = new mnuEdit();

// ***********************************************************
// show title
// ***********************************************************
$loc = PFS::getLoc();
$tit = PGE::getTitle($loc);

HTW::tag($tit, "h3");

// ***********************************************************
// show options
// ***********************************************************
$nav = new buttons("menu", "F", __DIR__);

$nav->add("D", "doFolders");
$nav->add("F", "doFiles");
$nav->add("A", "doUpload");
$nav->add("P", "doProps", "props");
$nav->add("R", "doSort");
$nav->add("S", "doStatic");
$nav->add("U", "doUser");
$nav->add("C", "doClip");
$nav->show();

?>
