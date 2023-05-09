<?php

$tpl = new tpl();
$tpl->load("modules/search.tpl");

$fnd = ENV::get("search");
$old = "";

foreach ($fls as $fil => $arr) {
	$dir = dirname($fil);
	$nam = basename($fil);

	$num = STR::between($nam, ".", "."); $num = intval($num);
	$tit = PGE::getTitle($dir);
	$uid = PGE::getUID($dir);
	$cnt = 0;

	$tpl->set("titel", $tit);
	$tpl->set("page",  $uid);

	foreach ($arr as $txt) {
		if ($cnt++ > 0)
		$tpl->show("item.sep");

		$old = $tit;
		$txt = STR::mark($txt, $fnd);
		echo $txt;
	}
}

?>
