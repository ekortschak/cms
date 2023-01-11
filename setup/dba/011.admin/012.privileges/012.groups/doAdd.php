<?php

incCls("menus/dboBox.php");
incCls("input/selector.php");
incCls("dbase/dbInfo.php");
incCls("dbase/dbAlter.php");

$dbi = new dbInfo();

// ***********************************************************
// show menu
// ***********************************************************
$box = new dboBox();
$dbs = $box->getDbase();
$xxx = $box->show();

$sel = new selector();
$grp = $sel->input("usr.group", "new_group");
$act = $sel->show();

// ***********************************************************
HTW::xtag("grp.create"); // ask for confirmation
// ***********************************************************
$ddl = new dbAlter($dbs, "dbxs");
$ddl->f_add("dbxs", $grp, "var", 5, "x");

?>
