<?php

incCls("menus/dboBox.php");
incCls("dbase/dbAlter.php");
incCls("dbase/dbQuery.php");
incCls("input/selector.php");

// ***********************************************************
// show menu
// ***********************************************************
$box = new dboBox();
$dbs = $box->getDbase();

$dir = APP::bkpDir("", SRV_ROOT, "db.$dbs"); $bkp = dirname($dir);
$vrs = FSO::folders("$bkp/db.$dbs.*"); krsort($vrs);

foreach ($vrs as $key => $val) {
	$vrs[$key] = STR::after($val, "db.$dbs.");
}
$ver = $box->getKey("as of", $vrs);
$xxx = $box->show("menu");

HTM::cap("dir = $bkp", "small");

// ***********************************************************
// show tables
// ***********************************************************
$arr = FSO::files("$ver/*.bkp"); $tbs = array();

foreach ($arr as $fil => $tab) {
	$tab = STR::clear($tab, ".bkp");
	$tbs[$tab] = $tab;
}

HTM::tag("tbs.select");

$sel = new selector();
$exc = $sel->multi("tbs.restore", $tbs);
$act = $sel->show();

if (! $act) return;

// ***********************************************************
// process tables
// ***********************************************************
$dba = new dbAlter($dbs, $tbl); $dba->askMe(false);
$dbq = new dbQuery($dbs, $tbl);
$cnt = 0;

foreach ($exc as $tbl => $cap) {
	if (! $tbl) continue;

	$fil = FSO::join($ver, "$tbl.bkp");
	$dat = APP::read($fil);

	$ddl = STR::between($dat, "[ddl]", "[data]"); if (! $ddl) continue;
	$rcs = STR::after($dat, "[data]"); if (! $rcs) continue;
	$rcs = VEC::explode($rcs, "\n");

	$dba->set("tab", $tbl);
	$dba->t_drop($tbl);
	$dba->exec($ddl, "ddl");

	foreach ($rcs as $rec) {
		$rec = STR::replace($rec, '";"', '","');
		$rec = STR::replace($rec, '""', 'NULL');
		$rec = STR::replace($rec, '"0000-00-00"', 'NULL');

		$xxx = $dba->set("vls", $rec);
		$sql = $dba->fetch("mod.vls");
		$inf = $dbq->exec($sql, "ins");
	}
	$cnt++;
}

?>

<h4>Report</h4>
<p>Done: <?php echo $cnt; ?> tables</p>
