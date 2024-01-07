<?php

DBG::file(__FILE__);

// ***********************************************************
$btn = ENV::get("btn.xfer");

switch ($btn) {
	case "I": // merge into single file
		return incMod("toc/main.php");
}

// ***********************************************************
// show module
// ***********************************************************
$tpl = new tpl();
$tpl->load("menus/toc.xfer.tpl");
$tpl->show("all");

?>
