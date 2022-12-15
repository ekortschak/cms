<?php

incCls("menus/qikSelect.php");
incCls("input/selector.php");
incCls("dbase/dbInfo.php");
incCls("dbase/dbAlter.php");

// ***********************************************************
// show menu
// ***********************************************************
$box = new dbox();
$ret = $box->showDBObjs("BTC"); extract($ret);
$xxx = $box->show("menu");

$dbi = new dbInfo($dbs, $tbl);
$tps = $dbi->fldTypes();

$box = new qikSelect();
$typ = $box->getKey("change.to", $tps);

$nls = $dbi->fldNull($typ);
$lns = $dbi->fldLen($typ);

if ($typ != "mem")
$len = $box->getKey("fld.length", $lns);
$nul = $box->getKey("fld.null",   $nls);
$xxx = $box->show();

echo "<hr>";

// ***********************************************************
$fnc = "input"; $std = "";

switch ($typ) {
	case "dat": $typ = $len; break;
	case "num": $typ = $len; $fnc = "number"; $std = 0; break;
}

$sel = new selector();
$fld = $sel->input("fld.name", "new_name");
$std = $sel->$fnc("fld.default", $std);
$act = $sel->show();

// ***********************************************************
// ask for confirmation
// ***********************************************************
HTM::tag("fld.create");

$ddl = new dbAlter($dbs, $tbl);
$ddl->f_add($tbl, $fld, $typ, $len, $std, $nul);

?>
