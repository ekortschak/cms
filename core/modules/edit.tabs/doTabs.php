<?php

incCls("menus/tabset.php");
incCls("menus/dropbox.php");
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
$tpl->read("design/templates/editor/tabsets.tpl");
$dat = "";

foreach ($lst as $tab => $tit) {
	$tpl->set("tab", $tab);
	$tpl->set("title", $tit);
	$tpl->set("default", (STR::contains($vis[$tab], "default")) ? "CHECKED" : "");
	$tpl->set("visible", ($vis[$tab]) ? "CHECKED" : "");
	$tpl->set("local", (STR::contains($vis[$tab], "local")) ? "CHECKED" : "");

	$dat.= $tpl->getSection("row");
}
$tpl->set("tabset", $set);
$tpl->set("items", $dat);
$tpl->show();

// ***********************************************************
// add and drop tabs
// ***********************************************************
$tpl = new tpl();
$tpl->read("design/templates/editor/mnuTab.tpl");
$tpl->set("tabset", $set);
$tpl->show("add.tab");
$tpl->show("help");

?>
