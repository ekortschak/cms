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
$dir = $sel->input("dir", PGE::$dir);
$fnd = $sel->input("find", "$lng.htm");
$ren = $sel->input("rename", "$lng.htm");
$act = $sel->show();

if (! $act) return;

// ***********************************************************
// preview
// ***********************************************************
$arr = FSO::fTree($dir, $fnd);
$ttl = count($arr);
$cnt = 0;

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
echo "&nbsp; Renamed: $cnt/$ttl files\n";

?>

