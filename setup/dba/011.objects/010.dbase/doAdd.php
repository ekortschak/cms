<?php

incCls("menus/localMenu.php");
incCls("input/selector.php");
incCls("dbase/dbAlter.php");

// ***********************************************************
// show menu
// ***********************************************************
$box = new localMenu();
$erg = $box->showDBObjs("X"); extract($erg);
$xxx = $box->show();

$sel = new selector();
$neu = $sel->input("dbs.new", "new_database");
$act = $sel->show();

// ***********************************************************
// ask for confirmation
// ***********************************************************
HTM::tag("dbs.create");

$ddl = new dbAlter($dbs, $tbl);
$ddl->db_add($neu);

?>
