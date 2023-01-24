<?php

incCls("input/selector.php");
incCls("input/confirm.php");

// ***********************************************************
// react to previous commands
// ***********************************************************
$ptk = new ptracker();
$xxx = $ptk->watch();
$arr = $ptk->get("bkp.drop");

if ($arr) {
	foreach ($arr as $dir => $sel) {
		if (! $sel) continue;
		FSO::rmDir($dir);
	}
}

// ***********************************************************
HTW::xtag("bkp.manage");
// ***********************************************************
$dir = APP::arcDir($dev, "bkp");
$arr = FSO::folders($dir); if ($fls) krsort($fls);

// ***********************************************************
// show selector
// ***********************************************************
$sel = new selector();
$exc = $sel->multi("bkp.drop", $arr);
$act = $sel->show();

if (! $act) return;
if (! $exc) return;

// ***********************************************************
// ask for confirmation
// ***********************************************************
$cnf = new confirm();
$cnf->dic("bkp.drop.info");

foreach ($exc as $dir => $sel) {
	if (! $sel) continue;
	$cnf->add("&rarr; $dir");
}
$cnf->show();

?>

