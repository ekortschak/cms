<?php

$btn = ENV::get("btn.xfer");

switch ($btn) {
	case "I": case "X":
		incMod("toc/main.php");
		return;
}

// ***********************************************************
// show module
// ***********************************************************
$tpl = new tpl();
$tpl->read("design/templates/menus/toc.xform.tpl");
$tpl->show("all");

?>
