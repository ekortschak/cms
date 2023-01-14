<?php

incCls("menus/dropMenu.php");

$box = new dropMenu();
$dir = $box->folders(LOC_CSS);
$ful = $box->files($dir);
$xxx = $box->show();

// ***********************************************************
// show editor
// ***********************************************************
incCls("editor/cfgEdit.php");

$cfg = new cfgEdit();
$cfg->show($ful);

?>
