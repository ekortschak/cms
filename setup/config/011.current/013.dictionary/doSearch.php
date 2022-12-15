<?php

incCls("input/selector.php");

// ***********************************************************
HTM::tag("dic.search");
// ***********************************************************
$sel = new selector();
$lng = $sel->combo("unq.language", LNG::get(), CUR_LANG);
$fnd = $sel->input("find.dic", "*");
$act = $sel->show();

$dir = "design/dictionary/$lng";
$arr = FSO::ftree($dir);

// ***********************************************************
HTM::tag("dic.result");
// ***********************************************************
if (! $arr) {
	MSG::now("no local files ...");
	return;
}

// ***********************************************************
foreach ($arr as $fil => $nam) {
	$txt = APP::read($fil); if (! STR::contains($txt, $fnd)) continue;

	echo "<div><a href='?btn.dic=E&pic.folder=$dir&pic.file=$dir/$nam'>$nam</a></div>";
	echo "<ul>";
	$lns = explode("\n", $txt);

	foreach ($lns as $lin) {
		if (! STR::contains($lin, $fnd)) continue;
		echo "<li>$lin\n";
	}
	echo "</ul>";
}

?>
