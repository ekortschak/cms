<?php

if (TAB_TYPE != "sel") return;

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
$box = new dropBox("topics");
$box->getKey("tpc", $arr);
$box->show();

?>
