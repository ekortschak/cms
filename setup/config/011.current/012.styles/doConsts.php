<?php

incCls("menus/dropMenu.php");

$box = new dropMenu();
$ful = $box->files(LOC_LAY, "Layout", "default.ini");
$xxx = $box->show();

// ***********************************************************
// read and write data
// ***********************************************************
incCls("editor/iniMgr.php");

$ini = new iniMgr("LOC_CFG/css.dims.def");
$ini->exec($ful);
$ini->show();

?>
