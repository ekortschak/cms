<?php

// ***********************************************************
// show file selector
// ***********************************************************
incCls("menus/dropbox.php");

$box = new dbox();
$ful = $box->files("lookup", "file");
$xxx = $box->show("menu");

// ***********************************************************
// show editor
// ***********************************************************
incCls("editor/cfgEditor.php");

$cfg = new cfgEditor();
$cfg->show($ful);

?>
