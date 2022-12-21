<?php

incCls("menus/dboBox.php");
incCls("dbase/dbInfo.php");
incCls("tables/sel_table.php");

// ***********************************************************
// show menu
// ***********************************************************
$box = new dboBox();
$dbs = $box->getDbase();
$tbl = $box->getTable($dbs);
$xxx = $box->show();

$dbi = new dbInfo($dbs, $tbl);
$grp = $box->getKey("ugroup",    $dbi->usrGroups());
$rgt = $box->getKey("db.fperm",  $dbi->fldPerms());
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
