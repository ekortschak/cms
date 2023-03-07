<?php

incCls("menus/dropBox.php");

$box = new dropBox("menu");
$ful = $box->files(LOC_LAY, "Layout", "default.ini");
$xxx = $box->show();

HTW::tag("file = ".APP::relPath($ful), "hint");

// ***********************************************************
// read and write data
// ***********************************************************
incCls("editor/iniMgr.php");

$ini = new iniMgr("LOC_CFG/css.dims.def");
$ini->exec($ful);
$ini->show();

?>
