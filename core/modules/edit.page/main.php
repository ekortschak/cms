<?php

if (! FS_ADMIN) {
	incMod("stop.php");
	return;
}

incCls("menus/dropBox.php");
incCls("editor/ediMgr.php");

// ***********************************************************
// show title
// ***********************************************************
$fil = APP::find(CUR_PAGE);
$tit = PGE::getTitle();
$std = ENV::get("pic.file");
$std = FSO::join(CUR_PAGE, $std);

HTW::tag($tit, "h3");

// ***********************************************************
// show file selector
// ***********************************************************
$cur = basename(ENV::get("pic.file"));

$box = new dropBox("menu");
$fil = $box->files(CUR_PAGE, "pic.file", $std);

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
