<?php

incCls("menus/dropMenu.php");

$box = new dropMenu();
$fil = $box->files(LOC_LAY, "Layout", "default.ini");
$xxx = $box->show();

// ***********************************************************
// read and write data
// ***********************************************************
incCls("editor/iniMgr.php");

$ini = new iniMgr("LOC_CFG/css.dims.ini");
$ini->update($fil);
$ini->show();

?>
