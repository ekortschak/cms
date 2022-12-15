<?php

// ***********************************************************
// show file selector
// ***********************************************************
incCls("menus/localMenu.php");

$box = new localMenu();
$ful = $box->files("lookup");
$xxx = $box->show();

// ***********************************************************
// show editor
// ***********************************************************
incCls("editor/iniMgr.php");

$ini = new iniMgr("design/config/lookup.ini");
$ini->update($ful);
$ini->show();

?>
