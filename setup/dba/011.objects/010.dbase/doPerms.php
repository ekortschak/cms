<?php

incCls("menus/dropbox.php");
incCls("dbase/dbInfo.php");
incCls("tables/sel_table.php");

// ***********************************************************
// show menu
// ***********************************************************
$box = new dbox();
$erg = $box->showDbObjs("BT");   extract($erg);

$dbi = new dbInfo($dbs, $tbl);
$grp = $box->getKey("ugroup",    $dbi->usrGroups());
$rgt = $box->getKey("db.fperm",  $dbi->fldPerms());
$xxx = $box->show("menu");

// ***********************************************************
HTM::tag("tbl.perms");
// ***********************************************************
$few = new sel_table();
$few->setTable($dbs, "dbxs", "spec LIKE '$tbl.%'");
$few->setButton($grp, $rgt);
$few->setProp("cat", "hide", true);
$few->show();

?>
