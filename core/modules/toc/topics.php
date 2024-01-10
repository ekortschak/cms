<?php

if (TAB_TYPE != "sel") return;

incCls("menus/topics.php");
incCls("menus/dropBox.php");

// ***********************************************************
// collect data
// ***********************************************************
$tps = new topics();
$arr = $tps->getMarked(); if (! $arr) return;

switch (VMODE) {
	case "abstract": $nav = "nav.back"; break;
	default:         $nav = "nav";
}

// ***********************************************************
// show topics - if any
// ***********************************************************
$box = new dropBox("topics");
$box->substitute("nav", $nav);
$box->getKey("tpc", $arr);
$box->show();

?>
