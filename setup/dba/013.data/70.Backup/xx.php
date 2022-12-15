<?php

incCls("menus/localMenu.php");
incCls("dbase/dbInfo.php");
incCls("dbase/dbQuery.php");
incCls("input/selector.php");

// ***********************************************************
// show menu
// ***********************************************************
$arr = array(
	"bkp" => "Backup",
	"rst" => "Restore"
);

$box = new localMenu();
$ret = $box->showDBObjs("B"); extract($ret);
$fnc = $box->getKey("Method", $arr);
$xxx = $box->show("menu");

// ***********************************************************
// show tables
// ***********************************************************
$dbi = new dbInfo();
$tbs = $dbi->tables();

HTM::tag("tbs.select");

$sel = new selector();
$dat = $sel->multi("bkp.tables", $tbs);
$act = $sel->show();

if (! $act) return;

// ***********************************************************
// process tables
// ***********************************************************
$dir = APP::bkpDir("", SRV_ROOT, "db.$dbs");

$dbq = new dbQuery($dbs, $tbl);

foreach ($dat as $tbl => $cap) {
	$fil = FSO::join($dir, "$tbl.sql");

	$dbq->set("file", $fil);
	$dbq->set("tab", $tbl);

	$dbq->getRecs("bkp.bkp");
}

?>

<p>in Vorbereitung ...</p>
