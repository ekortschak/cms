<?php

// ***********************************************************
// show file selector
// ***********************************************************
incCls("menus/dropbox.php");

$box = new dbox();
$dir = $box->folders("design/templates", "Subset");
$ful = $box->files($dir, "file");
$xxx = $box->show("menu");


// ***********************************************************
// show editor
// ***********************************************************
incCls("editor/cfgEditor.php");

$cfg = new cfgEditor();
$cfg->show($ful);

?>
