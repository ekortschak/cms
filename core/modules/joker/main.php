<?php

incCls("menus/dropBox.php");

DBG::file(__FILE__);

// ***********************************************************
// find tabs
// ***********************************************************
$arr = CFG::iniGroup("tabsets:".TAB_SET);
$tbs = array();

foreach ($arr as $tab => $prp) {
	$ini = FSO::join($tab, "tab.ini");
	$tbs[$tab] = PGE::title($ini);
}

$box = new dropBox("button");
$xxx = $box->hideDesc();
$tab = $box->getKey("tab", $tbs);
$tbs = $box->gc();

// ***********************************************************
// adjustments to layout
// ***********************************************************
switch (LAYOUT) {
	case "default": $lyt = true; break;
	default: $lyt = false;
}

switch (VMODE) {
	case "view": case "toc": $clr = true; break;
	default: $clr = false;
}

// ***********************************************************
// show joker tool bar
// ***********************************************************
$tpl = new tpl();
$tpl->load("pages/joker.tpl");
$tpl->set("topics", $tbs);

if (! $lyt) $tpl->clearSec("menu");
if (! $clr) $tpl->substitute("right", "right.back");

$tpl->show();

?>
