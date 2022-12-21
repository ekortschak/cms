<?php

incCls("menus/dboBox.php");
incCls("input/selector.php");
incCls("dbase/dbAlter.php");

// ***********************************************************
// show menu
// ***********************************************************
$box = new dboBox();
$dbs = $box->getDbase();
$tbl = $box->getTable($dbs);
$xxx = $box->show();

// ***********************************************************
HTM::tag("tbl.rename");
// ***********************************************************
$sel = new selector();
$new = $sel->input("act.rename", $tbl."_old");
$act = $sel->show();

// ***********************************************************
// ask for confirmation
// ***********************************************************
$ddl = new dbAlter($dbs, $tbl);
$ddl->t_rename($tbl, $new);

?>
