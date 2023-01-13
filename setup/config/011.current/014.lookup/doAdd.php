<?php

incCls("input/selector.php");

$sel = new selector();
$fil = $sel->input("file.new");
$xxx = $sel->setProp("hint", "xy.ini");
$act = $sel->show();

if (! $act) return;
if (! $fil) return;

// ***********************************************************
// create file
// ***********************************************************
$fil = FSO::join("lookup", $fil);

APP::write($fil, "");

?>
