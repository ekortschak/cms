<?php

if (! FS_ADMIN) {
	incMod("stop.php");
	return;
}

incCls("menus/buttons.php");

// ***********************************************************
// show title
// ***********************************************************
$tit = PGE::getTitle();
HTW::tag($tit, "h3");

// ***********************************************************
$nav = new buttons("menu", "F", __DIR__);
// ***********************************************************
$nav->add("D", "doFolders");
$nav->add("P", "doProps",  "props");
$nav->add("R", "doSort",   "sort");
$nav->add("U", "doUser");
$nav->space();
$nav->add("F", "doFiles");
$nav->add("A", "doUpload", "upload");
$nav->space();
$nav->add("C", "doClip",   "clip");
$nav->space();
$nav->add("S", "doStatic", "static");
$nav->add("I", "doInfo",   "info");
$nav->show();

?>
