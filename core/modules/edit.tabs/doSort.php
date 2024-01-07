<?php

incCls("menus/dropBox.php");
incCls("menus/tabsets.php");

$tbs = new tabsets();
$lst = $tbs->getTabs(TAB_MODE);

// ***********************************************************
// show elements to sort
// ***********************************************************
$tpl = new tpl();
$tpl->load("editor/sort.items.tpl");
$tpl->register();

$its = "";
$ccc = 1;

foreach ($lst as $key => $val) {
	$tpl->set("text", $val);
	$tpl->set("cnt", $ccc++);
	$tpl->set("fso", $key);

	$its.= $tpl->getSection("item")."\n";
}

$tpl->set("sparm", TAB_MODE);
$tpl->set("items", $its);
$tpl->show();

?>
