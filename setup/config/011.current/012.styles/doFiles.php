<?php

$dir = "design/styles";

// ***********************************************************
// show file selector
// ***********************************************************
incCls("menus/dropbox.php");

$box = new dbox();
$dir = $box->folders($dir, "Layout");
$ful = $box->files($dir);
$xxx = $box->show("menu");

// ***********************************************************
// show editor
// ***********************************************************
incCls("editor/cfgEditor.php");

$cfg = new cfgEditor();
$cfg->show($ful);

?>
