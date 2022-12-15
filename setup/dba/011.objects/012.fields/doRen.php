<?php

incCls("menus/dropbox.php");
incCls("input/selector.php");
incCls("dbase/dbAlter.php");

// ***********************************************************
// show menu and options
// ***********************************************************
$box = new dbox();
$ret = $box->showDBObjs("BTF"); extract($ret);
$xxx = $box->show("menu");

$sel = new selector();
$new = $sel->input("act.rename", "new_name");
$act = $sel->show();

// ***********************************************************
// ask for confirmation
// ***********************************************************
HTM::tag("fld.rename");

$ddl = new dbAlter($dbs, $tbl);
$ddl->f_rename($tbl, $fld, $new);

?>
