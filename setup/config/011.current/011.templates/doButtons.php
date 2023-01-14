<?php

incCls("menus/dropMenu.php");

$box = new dropMenu();
$ful = $box->files(LOC_BTN);
$xxx = $box->show();

// ***********************************************************
// show editor
// ***********************************************************
incCls("editor/cfgEdit.php");

$cfg = new cfgEdit();
$cfg->show($ful);

?>
