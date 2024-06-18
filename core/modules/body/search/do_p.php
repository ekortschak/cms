<?php

DBG::file(__FILE__);

// ***********************************************************
// find results
// ***********************************************************
$dir = ENV::get("search.dir");
$fnd = ENV::get("search.what"); if (! $fnd) return;

$obj = new search();
$fls = $obj->snips($dir, $fnd);

// ***********************************************************
// show results
// ***********************************************************
$tpl = new tpl();
$tpl->load("modules/search.tpl");

foreach ($fls as $fil => $arr) {
	$dir = dirname($fil);
	$nam = basename($fil);

	$num = STR::between($nam, ".", "."); $num = intval($num);
	$tit = PGE::title($dir);
	$uid = PGE::UID($dir);
	$cnt = 0;

	$tpl->set("titel", $tit);
	$tpl->set("page",  $uid);

	foreach ($arr as $txt) {
		if ($cnt++ > 0)
		$tpl->show("item.sep");

		$txt = STR::mark($txt, $fnd);
		echo $txt;
	}
}

?>
