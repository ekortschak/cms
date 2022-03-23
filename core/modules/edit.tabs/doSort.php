<?php

incCls("menus/tabset.php");
incCls("menus/dropbox.php");

// ***********************************************************
// collect info
// ***********************************************************
$tbs = new tabset();
$arr = $tbs->validSets();

// ***********************************************************
// show file selector
// ***********************************************************
$box = new dbox();
$set = $box->getKey("TabSet", $arr, APP_CALL);
$xxx = $box->show("menu");

$lst = $tbs->getTabs($set, true);

// ***********************************************************
// show elements to sort
// ***********************************************************
$tpl = new tpl();
$tpl->read("design/templates/editor/sorter.tpl");

$sec = "main"; if (count($arr) < 2) $sec = "nodata";
$its = "";
$ccc = 1;

foreach ($lst as $key => $val) {
	$tpl->set("text", $val);
	$tpl->set("cnt", $ccc++);
	$tpl->set("fso", $key);

	$its.= $tpl->getSection("item")."\n";
}
$tpl->set("sparm", $set);
$tpl->set("items", $its);
$tpl->show($sec);

?>
