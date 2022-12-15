<?php

incCls("dbase/dbQuery.php");
incCls("dbase/dbInfo.php");
incCls("menus/qikSelect.php");
incCls("input/selector.php");
incCls("dbase/dbAlter.php");

// ***********************************************************
// show menu
// ***********************************************************
$box = new dbox();
$ret = $box->showDBObjs("BTF", false); extract($ret);
$xxx = $box->show("menu");

$dbi = new dbInfo($dbs, $tbl);
$tps = $dbi->fldTypes();
$inf = $dbi->fldProps($tbl, $fld);

$cat = $inf["dcat"];
$lng = $inf["flen"]; $len = "";

$box = new qikSelect();
$typ = $box->getKey("change.to", $tps, $cat);

$nls = $dbi->fldNull($typ);
$lns = $dbi->fldLen($typ);
$lng = $dbi->fldLenFind($typ, $lng);

if ($lng)
$len = $box->getKey("fld.length", $lns, $lng);
$nul = $box->getKey("fld.null",   $nls, $inf["fnull"]);
$xxx = $box->show();

echo "<hr>";

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
HTM::tag("fld.modify");

$ddl = new dbAlter($dbs, $tbl);
$ddl->f_modify($tbl, $fld, $typ, $len, $std, $nul);

?>