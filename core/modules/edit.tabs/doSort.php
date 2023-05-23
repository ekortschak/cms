<?php

incCls("menus/dropBox.php");

// ***********************************************************
// show elements to sort
// ***********************************************************
$tpl = new tpl();
$tpl->load("editor/sort.items.tpl");
$tpl->register();

$lst = PGE::tabsets(APP_CALL, true);

$its = "";
$ccc = 1;

foreach ($lst as $key => $val) {
	$tpl->set("text", $val);
	$tpl->set("cnt", $ccc++);
	$tpl->set("fso", $key);

	$its.= $tpl->getSection("item")."\n";
}

$tpl->set("sparm", APP_CALL);
$tpl->set("items", $its);
$tpl->show();

?>
