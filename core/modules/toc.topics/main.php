<?php

if (TAB_TYPE != "select") return;

// ***********************************************************
// show topics - if any
// ***********************************************************
incCls("menus/topics.php");
incCls("menus/tabs.php");

$tab = new tabs();
$arr = $tab->getTopics();

foreach ($arr as $key => $val) {
	if (STR::contains($key, "~")) $arr[$key] = "# $val";
}

$box = new topics();
$box->getKey("tpc", $arr);
$box->show();

?>
