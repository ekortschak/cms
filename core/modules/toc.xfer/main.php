<?php

$btn = ENV::get("btn.xfer");

switch ($btn) {
	case "I": // merge into single file
		incMod("toc.topics/main.php");
		incMod("toc.current/main.php");
		incMod("toc/main.php");
		return;
}

// ***********************************************************
// show module
// ***********************************************************
$tpl = new tpl();
$tpl->read("design/templates/menus/toc.xfer.tpl");
$tpl->show("all");

?>
