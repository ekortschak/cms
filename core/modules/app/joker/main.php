<?php

DBG::file(__FILE__);

incCls("menus/dropBox.php");
incCls("menus/topics.php");

// ***********************************************************
// find tabs
// ***********************************************************
$arr = CFG::match("tabsets:".TAB_SET);
$tbs = array();

foreach ($arr as $tab => $prp) {
	$ini = FSO::join($tab, "tab.ini");
	$tbs[$tab] = PGE::title($ini);
}

$tps = new topics();
$arr = $tps->items();

$box = new dropBox();
$box->hideDesc();

$tab = $box->getKey("tab", $tbs);
$tpc = $box->getKey("tpc.$tab", $arr, TAB_HOME);

$tbs = $box->gc();

// ***********************************************************
// show joker tool bar
// ***********************************************************
$tpl = new tpl();
$tpl->load("pages/joker.tpl");
$tpl->set("topics", $tbs);

// ***********************************************************
// adjustments to layout
// ***********************************************************
$clr = APP::isView();
$sch = CFG::mod("tabs.search");

if (! $clr) $tpl->substitute("right", "right.back");
if (! $sch) $tpl->clearSec("search");

$tpl->show();

?>
