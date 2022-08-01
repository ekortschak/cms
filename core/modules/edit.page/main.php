<?php

if (! IS_LOCAL) if (! FS_ADMIN) {
	$mod = "stop";
	$edt = CFG::getVar("mods", "deco.pedit", false);
	if ($edt) $mod = "login";

	incMod("body/$mod.php");
	return;
}

// ***********************************************************
// show title
// ***********************************************************
$loc = PFS::getLoc();
$tit = HTM::pgeTitle($loc);
$fil = ENV::getParm("pic.file");

HTM::cap($tit, "h3");

// ***********************************************************
// show file selector
// ***********************************************************
incCls("menus/dropbox.php");

$box = new dbox();
$fil = $box->anyfiles($loc, "pic.file", $fil);

// ***********************************************************
// find relevant editors
// ***********************************************************
incCls("editor/ediTools.php");

$edi = new ediTools();
$sec = $edi->getType($fil);
$eds = $edi->getEditors($sec);

if ($eds)
$sec = $box->getKey("pic.editor", $eds, EDITOR);
$xxx = $box->show("menu");

$bar = $edi->getToolbar($sec);

// ***********************************************************
// show module
// ***********************************************************
switch ($sec) {
	case "ini":  $inc = "doIni.php";   break;
	case "xdic": $inc = "doXLate.php"; break;
	default:     $inc = "doEdit.php";
}

$dir = FSO::mySep(__DIR__);
$inc = FSO::join($dir, $inc);
$inc = APP::file($inc);

return include($inc);

?>

