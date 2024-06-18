<?php

DBG::file(__FILE__);

incCls("menus/dropBox.php");

// ***********************************************************
// find tabs
// ***********************************************************
$arr = CFG::match("tabsets:".TAB_SET);
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
$clr = APP::isView();
$sch = CFG::mod("tabs.search");

// ***********************************************************
// show joker tool bar
// ***********************************************************
$tpl = new tpl();
$tpl->load("pages/joker.tpl");
$tpl->set("topics", $tbs);

if (! $clr) $tpl->substitute("right", "right.back");
if (! $sch) $tpl->clearSec("search");

$tpl->show();

?>
