<?php

incCls("menus/localMenu.php");
incCls("input/selector.php");
incCls("dbase/dbAlter.php");

// ***********************************************************
// show menu
// ***********************************************************
$box = new localMenu();
$erg = $box->showDBObjs("BT"); extract($erg);
$xxx = $box->show("menu");

$sel = new selector();
$neu = $sel->input("tbl.new", "new_table");
$act = $sel->show();

// ***********************************************************
// ask for confirmation
// ***********************************************************
HTM::tag("tbl.copy");

$ddl = new dbAlter($dbs, $tbl);
$ddl->t_copy($tbl, $neu);

?>
