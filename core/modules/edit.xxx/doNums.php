<?php

incCls("menus/dropbox.php");
incCls("input/selector.php");

HTM::tag("nums.conv");

// ***********************************************************
// get parameters
// ***********************************************************
$loc = PFS::getLoc();
$lng = CUR_LANG;

$sel = new selector();
$oid = $sel->register("search.xxx");
$dir = $sel->ronly("dir", $loc);
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
echo "<hr>\n";

?>

