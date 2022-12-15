<?php

$dir = "design/layout";

// ***********************************************************
// show file selector
// ***********************************************************
incCls("menus/localMenu.php");

$box = new localMenu();
$fil = $box->files($dir, "Layout", "default.ini");
$xxx = $box->show();

// ***********************************************************
// read and write data
// ***********************************************************
incCls("editor/iniMgr.php");

$ini = new iniMgr("design/config/css.dims.ini");
$ini->update($fil);
$ini->show();

?>
