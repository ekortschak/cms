<?php

incCls("menus/tabsets.php");

$tbs = new tabsets();
$lst = $tbs->getTabs(TAB_SET);
$vis = $tbs->visTabs(TAB_SET);

// ***********************************************************
HTW::xtag("tabs.toggle");
// ***********************************************************
$tpl = new tpl();
$tpl->load("editor/tabsets.tpl");
$tpl->register();
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
$tpl->set("tabset", TAB_SET);
$tpl->set("items", $dat);
$tpl->show();

?>
