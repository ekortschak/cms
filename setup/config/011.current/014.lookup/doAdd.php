<?php

incCls("input/selector.php");

$sel = new selector();
$fil = $sel->input("file.new");
$xxx = $sel->setProp("hint", "xy.ini");
$sel->show();

if (! $sel->act()) return;
if (! $fil) return;

// ***********************************************************
// create file
// ***********************************************************
$fil = FSO::join("lookup", $fil);

APP::write($fil, "");

?>
