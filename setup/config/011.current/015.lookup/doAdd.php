<?php

incCls("input/selector.php");

// ***********************************************************
$sel = new selector();
$fil = $sel->input("file.new");
$xxx = $sel->setProp("hint", "xy.dic");
$act = $sel->show();

if (! $act) return;
if (! $fil) return;

// ***********************************************************
// create file
// ***********************************************************
$arr = LNG::get();

foreach ($arr as $lng) {
	$fil = FSO::join("dictionary", $lng, $fil);
	APP::write($fil, "[dic.$lng]\n");
}

?>
