<?php

incCls("menus/localMenu.php");
incCls("dbase/dbInfo.php");
incCls("dbase/dbAlter.php");

// ***********************************************************
// show menu
// ***********************************************************
$dbi = new dbInfo();
$gps = $dbi->usrGroups(false); if (! $gps) $gps = "?";

$box = new localMenu();
$xxx = $box->set("sep", "");
$dbs = $box->getKey("pic.dbase", $dbi->dbases());
$grp = $box->getKey("ugroup", $gps);
$xxx = $box->show();

if ($grp == "?") {
	$tpl = new tpl();
	$tpl->load("msgs/dba.tpl");
	$tpl->show("no.groups");
	return;
}

// ***********************************************************
HTM::tag("grp.drop");

$ddl = new dbAlter($dbs, "dbxs");
$ddl->f_drop("dbxs", $grp);

?>
