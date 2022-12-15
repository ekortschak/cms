<?php

incCls("dbase/dbInfo.php");
incCls("menus/qikSelect.php");
incCls("dbase/dbAlter.php");

// ***********************************************************
// show menu and options
// ***********************************************************
$box = new qikSelect();
$ret = $box->showDBObjs("BTF"); extract($ret);
$xxx = $box->show("menu");

$dbi = new dbInfo($dbs, $tbl);
$arr = $dbi->fields($tbl, "%", $skip = $fld);

$aft = $box->getKey("fld.move after", $arr);
$xxx = $box->show();

// ***********************************************************
// ask for confirmation
// ***********************************************************
HTM::tag("fld.move");

$ddl = new dbAlter($dbs, $tbl);
$ddl->f_move($tbl, $fld, $aft);

?>
