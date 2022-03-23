<?php

incCls("dbase/dbInfo.php");
incCls("menus/dropbox.php");
incCls("dbase/dbAlter.php");

// ***********************************************************
// show menu and options
// ***********************************************************
$box = new dbox();
$ret = $box->showDBObjs("BTF"); extract($ret);

$dbi = new dbInfo($dbs, $tbl);
$arr = $dbi->fields($tbl, "%", $skip = $fld);

$aft = $box->getKey("fld.move after", $arr);
$xxx = $box->show("table");

// ***********************************************************
// ask for confirmation
// ***********************************************************
HTM::tag("fld.move");

$ddl = new dbAlter($dbs, $tbl);
$ddl->f_move($tbl, $fld, $aft);

?>
