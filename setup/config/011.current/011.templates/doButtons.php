<?php

$dir = "design/buttons";

// ***********************************************************
// show file selector
// ***********************************************************
incCls("menus/localMenu.php");

$box = new localMenu();
$ful = $box->files($dir);
$xxx = $box->show();

// ***********************************************************
// show editor
// ***********************************************************
incCls("editor/cfgEdit.php");

$cfg = new cfgEdit();
$cfg->show($ful);

?>
