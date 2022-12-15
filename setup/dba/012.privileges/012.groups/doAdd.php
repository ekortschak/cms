<?php

incCls("menus/localMenu.php");
incCls("input/selector.php");
incCls("dbase/dbInfo.php");
incCls("dbase/dbAlter.php");

$dbi = new dbInfo();

// ***********************************************************
// show menu
// ***********************************************************
$box = new localMenu();
$dbs = $box->getKey("pic.dbase", $dbi->dbases());
$xxx = $box->show();

$sel = new selector();
$grp = $sel->input("usr.group", "new_group");
$act = $sel->show();

// ***********************************************************
// ask for confirmation
// ***********************************************************
HTM::tag("grp.create");

$ddl = new dbAlter($dbs, "dbxs");
$ddl->f_add("dbxs", $grp, "var", 5, "x");

?>
