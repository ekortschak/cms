<?php

if (PFS::isStatic()) {
	return MSG::now("mnu.static");
}

// ***********************************************************
$arr = FSO::folders(CUR_PAGE); if (! $arr)
$arr = array();

$sec = "main"; if (count($arr) < 2)
$sec = "nodata";

// ***********************************************************
// show elements to sort
// ***********************************************************
$tpl = new tpl();
$tpl->load("editor/sort.items.tpl");
$tpl->register();

$its = ""; $ccc = 1;

foreach ($arr as $dir => $nam) {
	$tit = PGE::getTitle($dir);

	$tpl->set("text", $tit);
	$tpl->set("cnt", $ccc++);
	$tpl->set("fso", STR::clear($dir, CUR_PAGE));

	$its.= $tpl->getSection("item")."\n";
}
$tpl->set("items", $its);
$tpl->show($sec);

?>
