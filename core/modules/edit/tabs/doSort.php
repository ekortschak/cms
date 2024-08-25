<?php

incCls("menus/dropBox.php");
incCls("menus/tabsets.php");

$tbs = new tabsets();
$lst = $tbs->items(TAB_SET);

// ***********************************************************
// show elements to sort
// ***********************************************************
$tpl = new tpl();
$tpl->load("editor/sort.tabs.tpl");
$tpl->register();

$its = "";
$ccc = 1;

foreach ($lst as $key => $val) {
	$tpl->set("text", $val);
	$tpl->set("cnt", $ccc++);
	$tpl->set("fso", $key);

	$its.= $tpl->getSection("item")."\n";
}

$tpl->set("sparm", TAB_SET);
$tpl->set("items", $its);
$tpl->show();

?>
