<?php

incCls("menus/dropMenu.php");
incCls("editor/dicWriter.php");
incCls("editor/ediTools.php");

// ***********************************************************
// show file selector
// ***********************************************************
$box = new dropMenu();
$dir = $box->folders(LOC_DIC);
$fil = $box->files($dir);

$lng = basename($dir);

// ***********************************************************
// find relevant editors
// ***********************************************************
$edi = new ediTools();
$sec = $edi->getType($fil);
$eds = $edi->getEditors($sec);

if ($eds)
$sec = $box->getKey("pic.editor", $eds);
$xxx = $box->show();

// ***********************************************************
// show dic editor
// ***********************************************************
if ($sec == "dic") {
	incCls("editor/dicEdit.php");

	$dic = new dicEdit();
	$dic->exec($fil, $lng);
	$dic->show($fil, $lng);
	return;
}

// ***********************************************************
// show text editor
// ***********************************************************
$txt = APP::read($fil);

$tpl = new tpl();
$tpl->load("editor/edit.dic.tpl");
$tpl->set("content", $txt);
$tpl->show();

?>
