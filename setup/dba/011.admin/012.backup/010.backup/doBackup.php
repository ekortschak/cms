<?php

incCls("menus/dropDbo.php");
incCls("dbase/dbInfo.php");
incCls("dbase/dbAlter.php");
incCls("input/selector.php");

// ***********************************************************
// show menu
// ***********************************************************
$box = new dropDbo();
$dbs = $box->getDbase();
$xxx = $box->show();

$dir = APP::bkpDir("", SRV_ROOT, "db.$dbs");
HTW::tag("dir = $dir", "small");

// ***********************************************************
// table info
// ***********************************************************
$dbi = new dbInfo($dbs);
$tbs = $dbi->tables();

// ***********************************************************
HTW::xtag("tbs.select");
// ***********************************************************
$sel = new selector();
$exc = $sel->multi("tbs.backup", $tbs, true);
$act = $sel->show();

if (! $act) return;

// ***********************************************************
// process tables
// ***********************************************************
$dba = new dbAlter($dbs, $tbl);
$cnt = 0;

foreach ($exc as $tbl => $cap) {
	if (! $tbl) continue;

	$ddl = $dba->getDDL($tbl); $lin = "";
	$dat = $dba->getData(1);

	$fil = FSO::join($dir, "$tbl.bkp");
	$out = "[ddl]\n$ddl\n[data]\n$dat\n";
	$cnt++;

	APP::write($fil, $out);
}

?>

<h4>Report</h4>
<p>Backup: <?php echo $dir; ?> </p>
<p>Done: <?php echo $cnt; ?> tables</p>
