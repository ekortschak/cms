<?php

DBG::file(__FILE__);

// ***********************************************************
incCls("menus/tabsets.php");
incCls("menus/tabs.php");

$tbs = new tabsets();
$lst = $tbs->getTabs(TAB_SET);

// ***********************************************************
// read mods.ini
// ***********************************************************
$vis = CFG::mod("tabs.show", 1); if (! $vis) return;
$edt = CFG::mod("tabs.tedit", 0);
$sek = CFG::mod("tabs.search", 1);

// ***********************************************************
// show tabs
// ***********************************************************
$nav = new tabs();

switch (VMODE) {
	case "search": $nav->copy("search.return", "search"); break;
	case "tedit":  $nav->copy("return", "tedit");  break;
	case "opts":   $nav->copy("return", "opts");   break;
}

if (STR_contains(TAB_SET, "pres")) {
	$nav->copy("gohome", "tedit");
}

if (! $sek) $nav->clearSec("search");
if (! $edt) $nav->clearSec("tedit");

$nav->setData($lst);
$nav->show();

?>
