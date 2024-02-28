<?php

incCls("menus/tabsets.php");

$tbs = new tabsets();
$lst = $tbs->items(TAB_SET);

// ***********************************************************
HTW::xtag("tabs.toggle");
// ***********************************************************
$tpl = new tpl();
$tpl->load("editor/tabsets.tpl");
$tpl->register();
$dat = "";

foreach ($lst as $tab => $tit) {
	$tpl->set("tab",      $tab);
	$tpl->set("title",    $tit);
	$tpl->set("local",   ($tbs->isLocal(  TAB_SET, $tab)) ? "CHECKED" : "");
	$tpl->set("default", ($tbs->isDefault(TAB_SET, $tab)) ? "CHECKED" : "");
	$tpl->set("visible", ($tbs->isVisible(TAB_SET, $tab)) ? "CHECKED" : "");

	$dat.= $tpl->getSection("row");
}
$tpl->set("tabset", TAB_SET);
$tpl->set("items", $dat);
$tpl->show();

// ***********************************************************
// add or drop tabs
// ***********************************************************
$tpl = new tpl();
$tpl->load("editor/menu.tab.tpl");
$tpl->register();

$tpl->show("add");
$tpl->show("drop");

?>
