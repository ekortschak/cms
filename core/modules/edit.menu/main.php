<?php

// ***********************************************************
// login on remote system
// ***********************************************************
if (! IS_LOCAL) if (! FS_ADMIN) {
	$cfg = new ini("config/mods.ini");

	$mod = "stop";
	if ($cfg->get("online.medit")) $mod = "login";

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

$mds = new ini("config/mods.ini");

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
