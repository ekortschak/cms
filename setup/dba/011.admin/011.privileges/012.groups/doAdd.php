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
HTW::xtag("grp.create"); // ask for confirmation
// ***********************************************************
$sel = new selector();
$grp = $sel->input("usr.group", "new_group");
$act = $sel->show();

// ***********************************************************
// ask for confirmation
// ***********************************************************
$ddl = new dbAlter($dbs, "dbxs");
$ddl->f_add("dbxs", $grp, "var", 5, "x");

?>
