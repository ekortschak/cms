<?php

if (EDITING == "medit") {
	$btn = ENV::get("btn.menu");

	if ($btn == "S") {
		$tpl = new tpl();
		$tpl->read("design/templates/menus/toc.edit.tpl");
		$tpl->show("topic");
		return;
	}
}

// ***********************************************************
$sec = "main";

if (TAB_TYPE == "select")
if (TAB_ROOT == TAB_PATH) $sec = "no.topic";

// ***********************************************************
// show menu
// ***********************************************************
incCls("menus/toc.php");

$toc = new toc();
$toc->show($sec);

?>
