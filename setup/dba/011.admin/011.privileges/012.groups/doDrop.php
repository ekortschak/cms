<?php

incCls("menus/dboBox.php");
incCls("dbase/dbInfo.php");
incCls("dbase/dbAlter.php");

// ***********************************************************
// show menu
// ***********************************************************
$box = new dboBox();
$dbs = $box->getDbase();
$grp = $box->getGroups($dbs, false);
$xxx = $box->show();

if ($grp == "?") {
	$tpl = new tpl();
	$tpl->load("msgs/dba.tpl");
	$tpl->show("no.groups");
	return;
}

// ***********************************************************
HTW::xtag("grp.drop");
// ***********************************************************
$ddl = new dbAlter($dbs, "dbxs");
$ddl->f_drop("dbxs", $grp);

?>
