<?php

incCls("menus/localMenu.php");

$box = new localMenu();
$ful = $box->files(LOC_BTN);
$xxx = $box->show();

// ***********************************************************
// show editor
// ***********************************************************
incCls("editor/cfgEdit.php");

$cfg = new cfgEdit();
$cfg->show($ful);

?>
