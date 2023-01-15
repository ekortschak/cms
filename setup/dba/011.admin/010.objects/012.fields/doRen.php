<?php

incCls("menus/dropDbo.php");
incCls("input/selector.php");
incCls("dbase/dbAlter.php");

// ***********************************************************
// show menu and options
// ***********************************************************
$box = new dropDbo();
$dbs = $box->getDbase();
$tbl = $box->getTable($dbs);
$fld = $box->getField($dbs, $tbl);
$xxx = $box->show();

// ***********************************************************
HTW::xtag("fld.rename");
// ***********************************************************
$sel = new selector();
$new = $sel->input("new.name", "new_name");
$act = $sel->show();

// ***********************************************************
// ask for confirmation
// ***********************************************************
$ddl = new dbAlter($dbs, $tbl);
$ddl->f_rename($tbl, $fld, $new);

?>
