<?php

incCls("menus/dboBox.php");
incCls("menus/qikSelect.php");
incCls("dbase/dbInfo.php");
incCls("dbase/dbAlter.php");

// ***********************************************************
// show menu and options
// ***********************************************************
$box = new dboBox();
$dbs = $box->getDbase();
$tbl = $box->getTable($dbs);
$fld = $box->getField($dbs, $tbl);
$xxx = $box->show();

$dbi = new dbInfo($dbs, $tbl);
$arr = $dbi->fields($tbl, "%", $skip = $fld);

// ***********************************************************
HTM::tag("fld.move");
// ***********************************************************
$box = new qikSelect();
$aft = $box->getKey("fld.move after", $arr);
$xxx = $box->show();

// ***********************************************************
// ask for confirmation
// ***********************************************************
$ddl = new dbAlter($dbs, $tbl);
$ddl->f_move($tbl, $fld, $aft);

?>
