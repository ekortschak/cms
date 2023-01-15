<?php

incCls("dbase/dbQuery.php");
incCls("dbase/dbInfo.php");
incCls("menus/dropDbo.php");
incCls("input/selector.php");
incCls("dbase/dbAlter.php");

// ***********************************************************
// show menu
// ***********************************************************
$box = new dropDbo();
$dbs = $box->getDbase();
$tbl = $box->getTable($dbs);
$fld = $box->getField($dbs, $tbl);
$xxx = $box->show();

$dbi = new dbInfo($dbs, $tbl);
$tps = $dbi->fldTypes();
$inf = $dbi->fldProps($tbl, $fld);

$cat = $inf["dcat"];
$lng = $inf["flen"]; $len = "";

// ***********************************************************
HTW::xtag("fld.modify");
// ***********************************************************
$box = new dropBox();
$typ = $box->getKey("fld.type", $tps, $cat);

$nls = $dbi->fldNull($typ);
$lns = $dbi->fldLen($typ);
$lng = $dbi->fldLenFind($typ, $lng);

if ($lng)
$len = $box->getKey("fld.length", $lns, $lng);
$nul = $box->getKey("fld.null",   $nls, $inf["fnull"]);
$xxx = $box->show();

HTM::lf();

// ***********************************************************
$fnc = "input"; $std = "";

switch ($typ) {
	case "dat": $typ = $len; break;
	case "num": $typ = $len; $fnc = "number"; $std = 0; break;
}

$sel = new selector();
$std = $sel->$fnc("fld.default", $std);
$act = $sel->show();

// ***********************************************************
// ask for confirmation
// ***********************************************************
$ddl = new dbAlter($dbs, $tbl);
$ddl->f_modify($tbl, $fld, $typ, $len, $std, $nul);

?>
