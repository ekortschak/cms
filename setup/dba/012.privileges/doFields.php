<?php

incCls("menus/dboBox.php");
incCls("dbase/dbInfo.php");
incCls("tables/sel_table.php");

$dbi = new dbInfo();

// ***********************************************************
// show menu
// ***********************************************************
$box = new dboBox();
$dbs = $box->getDbase();
$tbl = $box->getTable($dbs);
$grp = $box->getKey("pic.group", $dbi->usrGroups());
$rgt = $box->getKey("pic.privs", $dbi->fldPerms());
$xxx = $box->show();

// ***********************************************************
HTM::tag("fld.perms");
// ***********************************************************
$few = new sel_table();
$few->setTable($dbs, "dbxs", "spec LIKE '$tbl.%'");
$few->setButton($grp, $rgt);
$few->setProp("spec", "head", DIC::get("db.field"));
$few->setProp("cat", "hide", true);
$few->show();

?>
