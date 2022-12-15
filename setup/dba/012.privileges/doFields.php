<?php

incCls("menus/localMenu.php");
incCls("dbase/dbInfo.php");
incCls("tables/sel_table.php");

$dbi = new dbInfo();

// ***********************************************************
// show menu
// ***********************************************************
$box = new localMenu();
$ret = $box->showDBObjs("BT"); extract($ret);
$xxx = $box->show("menu");

$xxx = $dbi->selectDb($dbs);

$grp = $box->getKey("group",   $dbi->usrGroups());
$rgt = $box->getKey("db.fperm", $dbi->fldPerms());
$xxx = $box->show();

// ***********************************************************
$hed = DIC::get("fld.perms");
// ***********************************************************
HTM::cap("$hed: $grp");

$few = new sel_table();
$few->setTable($dbs, "dbxs", "spec LIKE '$tbl.%'");
$few->setButton($grp, $rgt);
$few->setProp("cat", "hide", true);
$few->show();

?>