<?php

if (! IS_LOCAL) if (! FS_ADMIN) {
	$cfg = new ini("config/mods.ini");

	$mod = "stop";
	if ($cfg->get("online.pedit")) $mod = "login";

	incMod("body/$mod.php");
	return;
}

incCls("menus/qikScript.php");
incCls("editor/ediTools.php");

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
$box = new dbox();
$fil = $box->anyfiles($loc, "pic.file", $fil);

// ***********************************************************
// find relevant editors
// ***********************************************************
$edi = new ediTools();
$xxx = $edi->extEdit($fil);
$sec = $edi->getType($fil);
$dir = $edi->getPath();
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

