<?php

if (PFS::isStatic()) {
	return MSG::now("mnu.static");
}

$loc = PGE::$dir;

// ***********************************************************
$arr = FSO::dirs($loc); if (! $arr)
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
	$tit = PGE::title($dir);

	$tpl->set("text", $tit);
	$tpl->set("cnt", $ccc++);
	$tpl->set("fso", STR::clear($dir, $loc));

	$its.= $tpl->getSection("item")."\n";
}
$tpl->set("items", $its);
$tpl->show($sec);

?>
