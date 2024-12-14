<?php

incCls("input/selector.php");
incCls("input/ptracker.php");
incCls("input/confirm.php");

$mee = "bkp.drop";

// ***********************************************************
// react to previous commands
// ***********************************************************
$ptk = new ptracker();
$act = $ptk->watch();

if ($act) {
	$arr = $ptk->get($mee);

	foreach ($arr as $dir => $sel) {
		if ($sel) FSO::rmDir($dir);
	}
}

// ***********************************************************
HTW::xtag("bkp.manage");
// ***********************************************************
$dir = LOC::arcDir(APP_NAME, "bkp");
$arr = FSO::dirs($dir);
$arr = VEC::sort($arr, "krsort"); // latest first

// ***********************************************************
// show selector
// ***********************************************************
$sel = new selector();
$exc = $sel->multi($mee, $arr);
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

