<?php

incCls("menus/dropbox.php");
incCls("input/selector.php");
incCls("dbase/dbAlter.php");

// ***********************************************************
// show menu
// ***********************************************************
$box = new dbox();
$erg = $box->showDBObjs("BT"); extract($erg);

$sel = new selector();
$new = $sel->input("act.rename", $tbl."_old");
$act = $sel->show();

// ***********************************************************
// ask for confirmation
// ***********************************************************
HTM::tag("tbl.rename");

$ddl = new dbAlter($dbs, $tbl);
$ddl->t_rename($tbl, $new);

?>
