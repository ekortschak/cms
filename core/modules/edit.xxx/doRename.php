<?php

incCls("menus/dropbox.php");
incCls("input/selector.php");

HTM::tag("files.rename");

// ***********************************************************
// get parameters
// ***********************************************************
$loc = PFS::getLoc();
$lng = CUR_LANG;

$sel = new selector();
$oid = $sel->register("search.xxx");
$dir = $sel->ronly("dir", $loc);
$fnd = $sel->input("find", "$lng.htm");
$ren = $sel->input("rename", "$lng.htm");
$act = $sel->show();

if (! $act) return;

// ***********************************************************
// preview
// ***********************************************************
$arr = FSO::ftree($dir, $fnd);
$ttl = count($arr);
$cnt = 0;

echo "<hr>\n";
echo "<small><table>\n";

// ***********************************************************
// rename files
// ***********************************************************
foreach ($arr as $ful => $nam) {
	$dir = dirname($ful);
	$fil = basename($ful);

	$dst = STR::replace($fil, $fnd, $ren);
	$dst = FSO::join($dir, $dst);
	$cnt++;

#	rename($ful, $dst);
	dbg("rename to: $dst - deactivated");
}

echo "</table></small>\n";
echo "<hr>\n";
echo "&nbsp; Renamed: $cnt/$ttl files\n";
echo "<hr>\n";

?>

