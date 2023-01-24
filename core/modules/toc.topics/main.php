<?php

if (TAB_TYPE != "select") return;

incCls("menus/dropBox.php");
incCls("menus/tabs.php");

// ***********************************************************
// collect data
// ***********************************************************
$tab = new tabs();
$arr = $tab->getTopics();

foreach ($arr as $key => $val) { // mark hidden topics
	if (STR::contains($key, "~")) $arr[$key] = "# $val";
}

// ***********************************************************
// show topics - if any
// ***********************************************************
$box = new dropBox();
$box->getKey("tpc", $arr);
$box->suit("topics");
$box->show();

?>
