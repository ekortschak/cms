<?php

incCls("menus/dropBox.php");
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

$box = new dropBox("menu");
$fnc = $box->getKey("Method", $act);
$xxx = $box->show();

// ***********************************************************
// get parameters
// ***********************************************************
$lng = CUR_LANG;
$dbg = 1;

$sel = new selector();
$oid = $sel->register("search.xxx");
$dir = $sel->ronly("dir", PGE::$dir);
$ptn = $sel->input("file.pattern", "page.ini");
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
$arr = FSO::fTree($dir, $ptn);
$ttl = count($arr);
$cnt = $fds = 0;

$msg = DIC::get("files.containing");
HTW::tag("$msg '$fnd'");

// ***********************************************************
// find and/or replace strings
// ***********************************************************
echo "<small><table>\n";

$pge = new pageInfo();
$fnd = STR::replace($fnd, "<dqot>", '"');

foreach ($arr as $ful => $nam) {
	$txt = file_get_contents($ful); if (strlen($txt) < 1) continue;

	$res = PRG::find($txt, $fnd); if (! $res) continue;
	$fds+= $anz = count($res);
	$cnt++;

	if ($dbg) {
		$xxx = $pge->read($ful);
		$lnk = $pge->getLink($dir, "pedit");

		echo "<tr><td>$lnk</td><td align='right'>$anz</td></tr>";
	}
	elseif ($fnc == "replace") {
		$txt = PRG::replace($txt, $fnd, $rep);
		$res = FSO::write($ful, $txt);
	}
}

echo "</table></small>\n";
HTW::lf();
echo "&nbsp; Finds: $cnt/$ttl files => $fds occurrencies\n";
HTW::lf();

?>
