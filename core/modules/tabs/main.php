<?php

incCls("menus/tabs.php");

// ***********************************************************
// read mods.ini
// ***********************************************************
$vis = CFG::getVar("mods", "tabs.show", 1); if (! $vis) return;
$edt = CFG::getVar("mods", "tabs.tedit", 0);
$sek = CFG::getVar("mods", "tabs.search", 1);

$stc = ENV::get("output"); if ($stc == "static") return;

if (STR::contains(APP_FILE, "admin.php")) $vis = $edt = 1;

// ***********************************************************
// show vertical tabs
// ***********************************************************
$nav = new tabs();
$nav->readCfg();

switch (VMODE) {
	case "search": $nav->substitute("search", "return"); break;
	case "tedit":  $nav->substitute("tedit",  "tview");  break;
}

if (! $sek) $nav->clearSec("search");
if (! $edt) $nav->clearSec("tedit");

$nav->show();

?>

