<?php

if (TAB_TYPE != "select") return;

// ***********************************************************
// show topics - if any
// ***********************************************************
incCls("menus/dropbox.php");
incCls("menus/tabs.php");

$tab = new tabs();
$arr = $tab->getTopics();

$box = new dbox();
$box->getKey("tpc", $arr);
$box->show("topic");

?>
