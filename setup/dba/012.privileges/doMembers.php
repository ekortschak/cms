<?php

incCls("menus/localMenu.php");
incCls("tables/sel_table.php");

$dbi = new dbInfo();

// ***********************************************************
// show menu
// ***********************************************************
$box = new localMenu();
$dbs = $box->getKey("pic.dbase", $dbi->dbases());
$xxx = $dbi->selectDb($dbs);

$grp = $box->getKey("group",   $dbi->usrGroups());
$rgt = $box->getKey("db.mperm", $dbi->usrPerms());
$xxx = $box->show();

// ***********************************************************
$hed = DIC::get("grp.members");
// ***********************************************************
HTM::cap("$hed: $grp");

$few = new sel_table();
$few->setTable($dbs, "dbxs", "cat='usr'");
$few->setButton($grp, $rgt);
$few->setProp("cat", "hide", true);
$few->show();

?>
