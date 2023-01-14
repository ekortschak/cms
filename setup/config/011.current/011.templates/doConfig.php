<?php

$dir = "LOC_CFG";

// ***********************************************************
// show file selector
// ***********************************************************
incCls("menus/dropMenu.php");

$box = new dropMenu();
$ful = $box->files($dir);
$xxx = $box->show();

// ***********************************************************
// show editor
// ***********************************************************
incCls("editor/cfgEdit.php");

$cfg = new cfgEdit();
$cfg->show($ful);

?>
