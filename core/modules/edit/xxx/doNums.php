<?php

incCls("menus/dropBox.php");
incCls("input/selector.php");

HTW::xtag("conv.nums");

// ***********************************************************
// get parameters
// ***********************************************************
$sel = new selector();
$oid = $sel->register("search.xxx");
$dir = $sel->ronly("dir", PGE::$dir);
$act = $sel->show();

// ***********************************************************
// preview
// ***********************************************************
$arr = FSO::fTree($dir);

echo "<small>NOT YET\n";

// ***********************************************************
// rename files
// ***********************************************************
foreach ($arr as $ful => $nam) {
}

echo "</small>\n";

?>

