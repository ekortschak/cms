<?php

if (! FS_ADMIN) {
	incMod("stop.php");
	return;
}

incCls("menus/localMenu.php");
incCls("editor/ediTools.php");

// ***********************************************************
// show title
// ***********************************************************
$loc = PFS::getLoc();
$tit = HTM::pgeTitle($loc);
$fil = APP::find($loc);

HTW::tag($tit, "h3");

// ***********************************************************
// show file selector
// ***********************************************************
$cur = basename(ENV::get("pic.file"));

$box = new localMenu();
$fil = $box->anyfiles($loc, "pic.file");
$fil = $box->focus("pic.file", $cur, $fil);

// ***********************************************************
// find relevant editors
// ***********************************************************
$edi = new ediTools();
$sec = $edi->getType($fil);
$eds = $edi->getEditors($sec);

$sel = EDITOR; if ($sel == "default") $sel = $sec;

if ($eds)
$sec = $box->getKey("pic.editor", $eds, $sel);
$xxx = $box->show();

$bar = $edi->getToolbar($sec);

// ***********************************************************
// show module
// ***********************************************************
switch ($sec) {
	case "ini": $inc = "doIni.php"; break;
	case "pic": $inc = "doPic.php"; break;
	default:    $inc = "doEdit.php";
}

$dir = FSO::mySep(__DIR__);
$inc = FSO::join($dir, $inc);
$inc = APP::file($inc);

return include($inc);

?>
