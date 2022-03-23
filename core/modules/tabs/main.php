<?php

incCls("menus/tabs.php");

$qid = "deco"; if (! IS_LOCAL)
$qid = "online";

// ***********************************************************
// read mods.ini
// ***********************************************************
$cfg = new ini("config/mods.ini");
$vis = $cfg->get("tabs.show", 1); if (! $vis) return;
$edt = $cfg->get("$qid.tedit", 0);
$sch = $cfg->get("tabs.glass", 1);

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

