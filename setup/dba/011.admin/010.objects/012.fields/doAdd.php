<?php

incCls("menus/dboBox.php");
incCls("input/selector.php");
incCls("dbase/dbInfo.php");
incCls("dbase/dbAlter.php");

// ***********************************************************
// show menu
// ***********************************************************
$box = new dboBox();
$dbs = $box->getDbase();
$tbl = $box->getTable($dbs);
$xxx = $box->show();

$dbi = new dbInfo($dbs, $tbl);
$tps = $dbi->fldTypes();

// ***********************************************************
HTW::xtag("fld.create");
// ***********************************************************
$box = new dropBox();
$typ = $box->getKey("fld.type", $tps);

$nls = $dbi->fldNull($typ);
$lns = $dbi->fldLen($typ);

if ($typ != "mem")
$len = $box->getKey("fld.length", $lns);
$nul = $box->getKey("fld.null",   $nls);
$xxx = $box->show();

HTM::lf();

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
$ddl = new dbAlter($dbs, $tbl);
$ddl->f_add($tbl, $fld, $typ, $len, $std, $nul);

?>
