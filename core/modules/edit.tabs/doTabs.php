<?php

incCls("menus/tabset.php");
incCls("menus/dropBox.php");
incCls("input/selector.php");

$set = APP_CALL;

// ***********************************************************
// collect info
// ***********************************************************
$tbs = new tabset();
$lst = $tbs->getTabs($set, true);
$vis = $tbs->visTabs($set);

// ***********************************************************
HTM::tag("tabs.toggle");
// ***********************************************************
$tpl = new tpl();
$tpl->load("editor/tabsets.tpl");
$dat = "";

foreach ($lst as $tab => $tit) {
	$chk = VEC::get($vis, $tab);

	$tpl->set("tab", $tab);
	$tpl->set("title", $tit);
	$tpl->set("local",   (STR::contains($chk, "local"))   ? "CHECKED" : "");
	$tpl->set("default", (STR::contains($chk, "default")) ? "CHECKED" : "");
	$tpl->set("visible", ($chk) ? "CHECKED" : "");

	$dat.= $tpl->getSection("row");
}
$tpl->set("tabset", $set);
$tpl->set("items", $dat);
$tpl->show();

// ***********************************************************
// add and drop tabs
// ***********************************************************
$tpl = new tpl();
$tpl->load("editor/mnuTab.tpl");
$tpl->set("tabset", $set);
$tpl->show("add.tab");
$tpl->show("help");

?>
