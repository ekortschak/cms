<?php

// ***********************************************************
// show file selector
// ***********************************************************
incCls("menus/dropBox.php");

$box = new dropBox("menu");
$ful = $box->files("lookup");
$xxx = $box->show();

// ***********************************************************
// show editor
// ***********************************************************
incCls("editor/iniMgr.php");

$ini = new iniMgr("LOC_CFG/lookup.def");
$ini->exec($ful);
$ini->show();

?>
