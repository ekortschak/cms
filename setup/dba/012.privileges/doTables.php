<?php

incCls("menus/localMenu.php");
incCls("dbase/dbInfo.php");
incCls("tables/sel_table.php");

$dbi = new dbInfo();

// ***********************************************************
// show menu
// ***********************************************************
$box = new localMenu();
$dbs = $box->getKey("pic.dbase", $dbi->dbases());
$xxx = $dbi->selectDb($dbs);

$grp = $box->getKey("pic.group", $dbi->usrGroups());
$rgt = $box->getKey("db.tperm",  $dbi->tblPerms());
$xxx = $box->show();

// ***********************************************************
$hed = DIC::get("tbl.perms");
// ***********************************************************
HTM::cap("$hed: $grp");

$few = new sel_table();
$few->setTable($dbs, "dbxs", "cat='tbl'");
$few->setButton($grp, $rgt);
$few->setProp("cat", "hide", true);
$few->show();

?>
