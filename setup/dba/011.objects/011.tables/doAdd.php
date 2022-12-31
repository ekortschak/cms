<?php

incCls("menus/dboBox.php");
incCls("input/selector.php");
incCls("dbase/dbAlter.php");

// ***********************************************************
// show menu
// ***********************************************************
$box = new dboBox();
$dbs = $box->getDbase();
$xxx = $box->show();

// ***********************************************************
HTW::xtag("tbl.create");
// ***********************************************************
$sel = new selector();
$neu = $sel->input("tbl.new", "new_table");
$act = $sel->show();

// ***********************************************************
// ask for confirmation
// ***********************************************************
$ddl = new dbAlter($dbs);
$ddl->t_add($neu);

?>

