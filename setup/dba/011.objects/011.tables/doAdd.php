<?php

incCls("menus/localMenu.php");
incCls("input/selector.php");
incCls("dbase/dbAlter.php");

// ***********************************************************
// show menu
// ***********************************************************
$box = new localMenu();
$erg = $box->showDBObjs("BN"); extract($erg);
$xxx = $box->show();

$sel = new selector();
$neu = $sel->input("tbl.new", "new_table");
$act = $sel->show();

// ***********************************************************
// ask for confirmation
// ***********************************************************
HTM::tag("tbl.create");

$ddl = new dbAlter($dbs, $tbl);
$ddl->t_add($neu);

?>

