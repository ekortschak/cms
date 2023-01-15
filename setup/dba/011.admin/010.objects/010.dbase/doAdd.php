<?php

incCls("menus/dropDbo.php");
incCls("input/selector.php");
incCls("dbase/dbAlter.php");

// ***********************************************************
// show menu
// ***********************************************************
$box = new dropDbo();
$dbs = $box->getDbase();
$xxx = $box->show();

// ***********************************************************
HTW::xtag("dbs.create");
// ***********************************************************
$sel = new selector();
$neu = $sel->input("dbs.new", "new_database");
$act = $sel->show();

// ***********************************************************
// ask for confirmation
// ***********************************************************
$ddl = new dbAlter($dbs);
$ddl->db_add($neu);

?>
