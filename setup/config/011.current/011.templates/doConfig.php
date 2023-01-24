<?php

incCls("menus/dropBox.php");
incCls("editor/ediMgr.php");

// ***********************************************************
// show file selector
// ***********************************************************
$box = new dropBox("menu");
$ful = $box->files(LOC_CFG);
$xxx = $box->show();

// ***********************************************************
// show editor
// ***********************************************************
$edi = new ediMgr();
$edi->read($ful);
$edi->show("code");

?>
