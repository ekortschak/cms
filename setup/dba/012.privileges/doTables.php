<?php

incCls("menus/localMenu.php");
incCls("dbase/dbInfo.php");
incCls("tables/sel_table.php");

$dbi = new dbInfo();

// ***********************************************************
// show menu
// ***********************************************************
$box = new localMenu();
$box->set("sep", "");

$dbs = $box->getKey("pic.dbase", $dbi->dbases()); $dbi->selectDb($dbs);
$grp = $box->getKey("pic.group", $dbi->usrGroups());
$rgt = $box->getKey("pic.privs", $dbi->tblPerms());
$xxx = $box->show();

// ***********************************************************
HTM::tag("tbl.perms");
// ***********************************************************
$few = new sel_table();
$few->setTable($dbs, "dbxs", "cat='tbl'");
$few->setButton($grp, $rgt);
$few->setProp("spec", "head", DIC::get("db.table"));
$few->setProp("cat", "hide", true);
$few->show();

?>
