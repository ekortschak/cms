<?php

incCls("menus/dropbox.php");
incCls("dbase/dbInfo.php");
incCls("dbase/dbAlter.php");

// ***********************************************************
// show menu
// ***********************************************************
$dbi = new dbInfo();
$arr = $dbi->usrGroups(false);

$box = new dbox();
$dbs = $box->getKey("pic.dbase", $dbi->dbases());
$grp = $box->getKey("ugroup", $arr);
$xxx = $box->show("menu");

if (! $grp) {
	$tpl = new tpl();
	$tpl->read("design/templates/msgs/dba.tpl");
	$tpl->show("no.groups");
	return;
}

// ***********************************************************
HTM::tag("grp.drop");

$ddl = new dbAlter($dbs, "dbxs");
$ddl->f_drop("dbxs", $grp);

?>
