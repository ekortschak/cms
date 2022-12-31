<?php

incCls("menus/localMenu.php");
incCls("input/selector.php");
incCls("files/pageInfo.php");

HTW::xtag("files.search");

// ***********************************************************
// Choose action
// ***********************************************************
$act = array(
	"search"  => "Search",
	"replace" => "Search & Replace"
);

$box = new localMenu();
$fnc = $box->getKey("Method", $act);
$xxx = $box->show();

// ***********************************************************
// get parameters
// ***********************************************************
$loc = PFS::getLoc();
$lng = CUR_LANG;
$dbg = 1;

$sel = new selector();
$oid = $sel->register("search.xxx");
$dir = $sel->ronly("dir", $loc);
$ptn = $sel->input("file.pattern", "$lng.htm");
$fnd = $sel->input("find", "xy");

if ($fnc == "replace") {
	$rep = $sel->input("replace", $fnd);
	$dbg = $sel->check("opt.debug", 1);
}
$act = $sel->show();

if (! $act) return;

// ***********************************************************
// preview
// ***********************************************************
$arr = FSO::ftree($dir, $ptn);
$ttl = count($arr);
$cnt = $fds = 0;

$pge = new pageInfo();

HTM::lf();
echo "<small><table>\n";

// ***********************************************************
// find and/or replace strings
// ***********************************************************
foreach ($arr as $ful => $nam) {
	$txt = file_get_contents($ful); if (strlen($txt) < 1) continue;

	$erg = PRG::find($txt, $fnd); if (! $erg) continue;
	$fds+= $anz = count($erg);
	$cnt++;

	if ($dbg) {
		$xxx = $pge->read($ful);
		$lnk = $pge->getLink($dir, "pedit");

		echo "<tr><td>$lnk</td><td align='right'>$anz</td></tr>";
	}
	elseif ($fnc == "replace") {
		$txt = PRG::replace($txt, $fnd, $rep);
		$xxx = file_put_contents($ful, $txt);
	}
}

echo "</table></small>\n";
HTM::lf();
echo "&nbsp; Finds: $cnt/$ttl files => $fds occurrencies\n";
HTM::lf();

?>

