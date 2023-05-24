<?php

incCls("menus/dropBox.php");
incCls("input/selector.php");

HTW::xtag("nums.conv");

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
$arr = FSO::ftree($dir);

echo "<small>NOT YET\n";

// ***********************************************************
// rename files
// ***********************************************************
foreach ($arr as $ful => $nam) {
}

echo "</small>\n";
HTM::lf();

?>

