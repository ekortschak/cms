<?php

incCls("menus/localMenu.php");

$box = new localMenu();
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
