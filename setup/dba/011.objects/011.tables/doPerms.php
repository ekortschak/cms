<?php

incCls("menus/localMenu.php");
incCls("dbase/dbInfo.php");
incCls("tables/sel_table.php");

// ***********************************************************
// show menu
// ***********************************************************
$box = new localMenu();
$ret = $box->showDBObjs("BT");  extract($ret);
$xxx = $box->show("menu");

$dbi = new dbInfo($dbs, $tbl);
$grp = $box->getKey("ugroup",   $dbi->usrGroups());
$rgt = $box->getKey("db.fperm", $dbi->fldPerms());
$xxx = $box->show();

// ***********************************************************
HTM::tag("tbl.perms");
// ***********************************************************
$few = new sel_table();
$few->setTable($dbs, "dbxs", "spec LIKE '$tbl.%'");
$few->setButton($grp, $rgt);
$few->setProp("cat", "hide", true);
$few->show();

?>
