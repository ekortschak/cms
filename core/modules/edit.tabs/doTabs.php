<?php

incCls("menus/tabset.php");
incCls("menus/dropbox.php");
incCls("input/selector.php");

// ***********************************************************
// collect info
// ***********************************************************
$tbs = new tabset();
$arr = $tbs->validSets();

// ***********************************************************
// show file selector
// ***********************************************************
$box = new dbox();
$set = $box->getVal("TabSet", $arr, APP_CALL);
$xxx = $box->show("menu");

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
	$tpl->set("visible", ($vis[$tab]) ? "CHECKED" : "");
	$tpl->set("default", ($vis[$tab] == "default") ? "CHECKED" : "");

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
