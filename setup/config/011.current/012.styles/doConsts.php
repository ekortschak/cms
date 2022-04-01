<?php

$dir = "design/layout";

// ***********************************************************
// show file selector
// ***********************************************************
incCls("menus/dropbox.php");

$box = new dbox();
$fil = $box->files($dir, "Layout", "default.ini");
$xxx = $box->show("menu");

// ***********************************************************
// read and write data
// ***********************************************************
incCls("editor/iniMgr.php");

$ini = new iniMgr("design/config/css.dims.ini");
$ini->read($fil);
$ini->save($fil);
$ini->show();

?>
