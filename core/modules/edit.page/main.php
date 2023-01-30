<?php

if (! FS_ADMIN) {
	incMod("stop.php");
	return;
}

incCls("menus/dropBox.php");
incCls("editor/ediMgr.php");
incCls("editor/saveFile.php");

// ***********************************************************
// react to previous commands
// ***********************************************************
$obj = new saveFile();

// ***********************************************************
// show title
// ***********************************************************
$fil = APP::find(CUR_PAGE);
$tit = PGE::getTitle();

HTW::tag($tit, "h3");

// ***********************************************************
// show file selector
// ***********************************************************
$cur = basename(ENV::get("pic.file"));

$box = new dropBox("menu");
$fil = $box->anyfiles(CUR_PAGE, "pic.file");
$fil = $box->focus("pic.file", $cur, $fil);

// ***********************************************************
// find relevant editors
// ***********************************************************
$edi = new ediMgr();
$xxx = $edi->read($fil);
$utl = $edi->getType();
$eds = $edi->getEditors();

$sel = EDITOR; if ($sel == "default") $sel = $utl;

if ($eds)
$utl = $box->getKey("pic.editor", $eds, $sel);
$xxx = $box->show();

// ***********************************************************
// show editor
// ***********************************************************
$edi->show($utl);

?>
