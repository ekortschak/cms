<?php

incCls("menus/dropDbo.php");
incCls("dbase/dbInfo.php");
incCls("dbase/dbAlter.php");

// ***********************************************************
// show menu
// ***********************************************************
$box = new dropDbo();
$dbs = $box->getDbase();
$grp = $box->getGroups($dbs, false);
$xxx = $box->show();

if (! $grp) {
	MSG::now("no.grps.edit");

#	$tpl = new tpl();
#	$tpl->load("msgs/dba.tpl");
#	$tpl->show("no.groups");
	return;
}

// ***********************************************************
HTW::xtag("grp.drop");
// ***********************************************************
$ddl = new dbAlter($dbs, "dbxs");
$ddl->f_drop("dbxs", $grp);

?>
