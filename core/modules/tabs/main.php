<?php

DBG::file(__FILE__);

// ***********************************************************
incCls("menus/tabsets.php");
incCls("menus/tabs.php");

$tbs = new tabsets();
$lst = $tbs->items(TAB_SET);

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

if (! $sek) $nav->clearSec("search");
if (! $edt) $nav->clearSec("tedit");

switch (VMODE) {
	case "search": $nav->copy("search.return", "search"); break;
}

$nav->setData($lst);
$nav->show();

?>
