<?php

incCls("menus/dropDbo.php");
incCls("dbase/dbInfo.php");
incCls("dbase/dbAlter.php");

// ***********************************************************
// show menu and options
// ***********************************************************
$box = new dropDbo();
$dbs = $box->getDbase();
$tbl = $box->getTable($dbs);
$fld = $box->getField($dbs, $tbl);
$xxx = $box->show();

$dbi = new dbInfo($dbs, $tbl);
$arr = $dbi->fields($tbl, "%", $skip = $fld);
unset($arr[$fld]);

// ***********************************************************
HTW::xtag("fld.move");
// ***********************************************************
$box = new dropBox();
$aft = $box->getKey("fld.move after", $arr);
$xxx = $box->show();

// ***********************************************************
// ask for confirmation
// ***********************************************************
$ddl = new dbAlter($dbs, $tbl);
$ddl->f_move($tbl, $fld, $aft);

?>
