<?php

if (PFS::isStatic()) {
	return MSG::now("menu.static");
}

// ***********************************************************
$loc = PFS::getLoc();
$arr = FSO::folders($loc); if (! $arr)
$arr = array();

$sec = "main"; if (count($arr) < 2)
$sec = "nodata";

// ***********************************************************
// show elements to sort
// ***********************************************************
$tpl = new tpl();
$tpl->read("design/templates/editor/sorter.tpl");
$its = ""; $ccc = 1;

foreach ($arr as $dir => $nam) {
	$tit = HTM::pgeTitle($dir);

	$tpl->set("text", $tit);
	$tpl->set("cnt", $ccc++);
	$tpl->set("fso", STR::clear($dir, $loc));

	$its.= $tpl->getSection("item")."\n";
}
$tpl->set("items", $its);
$tpl->show($sec);

?>
