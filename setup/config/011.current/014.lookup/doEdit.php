<?php

// ***********************************************************
// show file selector
// ***********************************************************
incCls("menus/dropMenu.php");

$box = new dropMenu();
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
