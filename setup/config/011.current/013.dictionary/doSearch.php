<?php

incCls("input/selector.php");

// ***********************************************************
HTW::xtag("dic.search");
// ***********************************************************
$sel = new selector();
$lng = $sel->combo("unq.language", LNG::get(), CUR_LANG);
$fnd = $sel->input("find.dic", "*");
$act = $sel->show();

$dir = FSO::join(LOC_DIC, $lng);
$arr = FSO::ftree($dir);

// ***********************************************************
HTW::xtag("dic.result");
// ***********************************************************
if (! $arr) {
	MSG::now("no local files ...");
	return;
}

// ***********************************************************
foreach ($arr as $fil => $nam) {
	$txt = APP::read($fil); if (! STR::contains($txt, $fnd)) continue;
	$lnk = HTM::href("?btn.dic=E&pic.folder=$dir&pic.file=$dir/$nam'", "$nam");
	$xxx = HTW::tag($lnk, "div");

	echo "<ul>";
	$lns = STR::slice($txt);

	foreach ($lns as $lin) {
		if (! STR::contains($lin, $fnd)) continue;
		HTW::tag($lin, "li");
	}
	echo "</ul>";
}

?>
