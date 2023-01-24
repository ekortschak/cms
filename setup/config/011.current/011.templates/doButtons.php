<?php

incCls("menus/dropMenu.php");
incCls("editor/ediMgr.php");

// ***********************************************************
// show file selector
// ***********************************************************
$box = new dropMenu();
$ful = $box->files(LOC_BTN);
$xxx = $box->show();

// ***********************************************************
// show editor
// ***********************************************************
$edi = new ediMgr();
$edi->read($ful);
$edi->show("code");

?>
