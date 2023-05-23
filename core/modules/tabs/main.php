<?php

incCls("menus/tabs.php");

// ***********************************************************
// read mods.ini
// ***********************************************************
$vis = CFG::getVal("mods", "tabs.show", 1); if (! $vis) return;
$edt = CFG::getVal("mods", "tabs.tedit", 0);
$sek = CFG::getVal("mods", "tabs.search", 1);

// ***********************************************************
// show tabs
// ***********************************************************
$nav = new tabs();

switch (VMODE) {
	case "search": $nav->copy("return", "search"); break;
	case "tedit":  $nav->copy("tview",  "tedit");  break;
}
if (! $sek) $nav->clearSec("search");
if (! $edt) $nav->clearSec("tedit");

$nav->setData(PGE::tabsets());
$nav->show();

?>

