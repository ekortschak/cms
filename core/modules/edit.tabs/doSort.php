<?php

incCls("menus/tabset.php");
incCls("menus/dropBox.php");

$set = APP_CALL;

// ***********************************************************
// collect info
// ***********************************************************
$tbs = new tabset();
$lst = $tbs->getTabs($set, true);

// ***********************************************************
// show elements to sort
// ***********************************************************
$tpl = new tpl();
$tpl->load("editor/sort.items.tpl");

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
$tpl->show();

?>
