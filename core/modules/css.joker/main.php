<?php

incCls("menus/dropBox.php");

// ***********************************************************
// find tabs
// ***********************************************************
$arr = CFG::getValues("tabsets:".TAB_SET);
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

// ***********************************************************
// show joker tool bar
// ***********************************************************
$tpl = new tpl();
$tpl->load("pages/css.joker.tpl");
$tpl->set("topics", $tbs); if (! $lyt)
$tpl->clearSec("menu");
$tpl->show();

?>
