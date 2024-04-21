<?php

DBG::file(__FILE__);

// ***********************************************************
// check if applicable
// ***********************************************************
if (TAB_TYPE != "sel") return;

incCls("menus/topics.php");
incCls("menus/dropBox.php");

// ***********************************************************
// collect data
// ***********************************************************
$tps = new topics();
$arr = $tps->items(); if (! $arr) return;

// ***********************************************************
// show topics - if any
// ***********************************************************
$box = new dropBox("topics");

if (VMODE == "abstract")
$box->substitute("nav", "nav.back");

$box->getKey("tpc", $arr);
$box->show();

?>
