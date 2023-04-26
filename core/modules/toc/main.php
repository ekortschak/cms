<?php

if (VMODE == "medit") {
	$btn = ENV::get("btn.menu");

	if ($btn == "S") {
		$tpl = new tpl();
		$tpl->load("menus/toc.edit.tpl");
		$tpl->show("topic");
		return;
	}
}

// ***********************************************************
$sec = "main";

if (TAB_TYPE == "sel")
if (TAB_ROOT == TAB_PATH) $sec = "no.topic";

// ***********************************************************
// show menu
// ***********************************************************
incCls("menus/toc.php");

$toc = new toc();
$toc->show($sec);

?>
