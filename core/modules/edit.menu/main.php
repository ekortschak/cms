<?php

// ***********************************************************
// login on remote system
// ***********************************************************
if (! FS_ADMIN) {
	$edt = CFG::getVar("mods", "eopts.medit", false);
	if ($edt) $mod = "login";

	incMod("body/$mod.php");
	return;
}

incCls("menus/buttons.php");

// ***********************************************************
// show title
// ***********************************************************
$dir = FSO::mySep(__DIR__);
$loc = PFS::getLoc();

$ini = new ini($loc);
$tit = $ini->getHead();

// ***********************************************************
HTM::cap($tit, "h3");
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