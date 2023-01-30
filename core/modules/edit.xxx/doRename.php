<?php

incCls("menus/dropBox.php");
incCls("input/selector.php");

HTW::xtag("files.rename");

// ***********************************************************
// get parameters
// ***********************************************************
$lng = CUR_LANG;

$sel = new selector();
$oid = $sel->register("search.xxx");
$dir = $sel->input("dir", CUR_PAGE);
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

HTM::lf();
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

	rename($ful, $dst);
}

echo "</table></small>\n";
HTM::lf();
echo "&nbsp; Renamed: $cnt/$ttl files\n";
HTM::lf();

?>

