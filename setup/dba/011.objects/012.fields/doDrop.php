<?php

incCls("menus/dboBox.php");
incCls("dbase/dbAlter.php");

// ***********************************************************
// show menu
// ***********************************************************
$box = new dboBox();
$dbs = $box->getDbase();
$tbl = $box->getTable($dbs);
$fld = $box->getField($dbs, $tbl);
$xxx = $box->show();

// ***********************************************************
// ask for confirmation
// ***********************************************************
HTM::tag("fld.drop");

$ddl = new dbAlter($dbs, $tbl);
$ddl->f_drop($tbl, $fld);

?>
