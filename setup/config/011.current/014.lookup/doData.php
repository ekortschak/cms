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
incCls("editor/cfgEdit.php");

$cfg = new cfgEdit();
$cfg->show($ful);

?>
