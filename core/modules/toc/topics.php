<?php

if (TAB_TYPE != "sel") return;

incCls("menus/topics.php");
incCls("menus/dropBox.php");

// ***********************************************************
// collect data
// ***********************************************************
$tps = new topics();
$arr = $tps->getMarked(); if (! $arr) return;

// ***********************************************************
// show topics - if any
// ***********************************************************
$box = new dropBox("topics");
$box->getKey("tpc", $arr);
$box->show();

?>
