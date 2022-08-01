<?php

incCls("menus/tabs.php");

// ***********************************************************
// read mods.ini
// ***********************************************************
$vis = CFG::getVar("mods", "tabs.show", 1); if (! $vis) return;
$edt = CFG::getVar("mods", "tabs.tedit", 0);
$sch = CFG::getVar("mods", "tabs.search", 1);

$stc = ENV::get("output"); if ($stc == "static") return;

if (STR::contains(APP_FILE, "admin.php")) $vis = $edt = 1;

// ***********************************************************
// show vertical tabs
// ***********************************************************
$nav = new tabs();
$nav->readCfg();

switch (EDITING) {
	case "search": $nav->substitute("search", "return"); break;
	case "tedit":  $nav->substitute("tedit",  "tview");  break;
}

if (! $sch) $nav->setSec("search", "");
if (! $edt) $nav->setSec("tedit", "");

$nav->show();

?>

