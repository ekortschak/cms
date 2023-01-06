<?php

$ptn = FSO::join(LOC_LOG, "*");
$drs = FSO::folders($ptn);

// ***********************************************************
incCls("menus/localMenu.php");
// ***********************************************************
$box = new localMenu();
$xxx = $box->set("sep", "");
$dir = $box->getKey("pic.folder", $drs);

$ptn = FSO::join($dir, "*");
$fls = FSO::files($ptn);

$ful = $box->getKey("pic.file", $fls, "error.log");
$xxx = $box->show();

// ***********************************************************
incCls("input/selector.php");
// ***********************************************************
$sel = new selector();
$flt = $sel->input("Filter");
$act = $sel->show();

$arr = file($ful);

echo "<pre><small>";

foreach ($arr as $lin) {
	if ($flt)
	if (! STR::contains($lin, $flt)) $lin = "";

	echo ltrim($lin);
}
echo "</small></pre>";

?>
