<?php

incCls("menus/dropBox.php");
incCls("editor/ediMgr.php");

// ***********************************************************
// show file selector
// ***********************************************************
$box = new dropBox("menu");
$dir = $box->folders(LOC_DIC);
$fil = $box->files($dir);

$lng = basename($dir);

// ***********************************************************
// find relevant editors
// ***********************************************************
$edi = new ediMgr();
$xxx = $edi->read($fil);
$utl = $edi->getType();
$eds = $edi->getEditors();

if ($eds)
$utl = $box->getKey("pic.editor", $eds);
$xxx = $box->show();

// ***********************************************************
// show editor
// ***********************************************************
$edi->show($utl);

?>
