<?php

if (! FS_ADMIN) {
	incMod("stop.php");
	return;
}

incCls("menus/dropMenu.php");
incCls("editor/ediTools.php");
incCls("editor/pgeEdit.php");

// ***********************************************************
// react to previous commands
// ***********************************************************
$obj = new pgeEdit();

// ***********************************************************
// show title
// ***********************************************************
$loc = PFS::getLoc();
$tit = PGE::getTitle($loc);
$fil = APP::find($loc);

HTW::tag($tit, "h3");

// ***********************************************************
// show file selector
// ***********************************************************
$cur = basename(ENV::get("pic.file"));

$box = new dropMenu();
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

// ***********************************************************
// show module
// ***********************************************************
switch ($sec) {
	case "ini": $inc = "doIni.php"; break;
	case "pic": $inc = "doPic.php"; break;
	case "dic": $inc = "doDic.php"; break;
	case "css": $inc = "doCss.php"; break;
	default:    $inc = "doEdit.php";
}

// ***********************************************************
// act
// ***********************************************************
include APP::getInc(__DIR__, $inc);

?>
