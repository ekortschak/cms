<?php

incCls("menus/dropMenu.php");
incCls("editor/ediMgr.php");

// ***********************************************************
// show file selector
// ***********************************************************
$box = new dropMenu();
$dir = $box->folders(LOC_TPL);
$ful = $box->files($dir);
$xxx = $box->show();

// ***********************************************************
// show editor
// ***********************************************************
$edi = new ediMgr();
$edi->read($ful);
$edi->show();

?>
