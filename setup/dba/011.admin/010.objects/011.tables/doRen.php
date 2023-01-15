<?php

incCls("menus/dropDbo.php");
incCls("input/selector.php");
incCls("dbase/dbAlter.php");

// ***********************************************************
// show menu
// ***********************************************************
$box = new dropDbo();
$dbs = $box->getDbase();
$tbl = $box->getTable($dbs);
$xxx = $box->show();

// ***********************************************************
HTW::xtag("tbl.rename");
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
