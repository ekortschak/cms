<?php

incCls("menus/dropbox.php");
incCls("dbase/tblFilter.php");
incCls("dbase/dbQuery.php");

$box = new dbox();
$erg = $box->showDBObjs("B"); extract($erg);

// ***********************************************************
// show filter
// ***********************************************************
$sel = new tblFilter($dbs, "dbusr"); // filter
$xxx = $sel->addFilter("uname");
$flt = $sel->getFilter();

$dbq = new dbQuery($dbs, "dbusr");
$lst = $dbq->getDVs("uname", $flt);

if (! $lst) {
	return MSG::now("tbl.empty", "dbusr");
}

// ***********************************************************
HTM::tag("usr.drop");

$box = new dbox();
$usr = $box->getKey("user", $lst);
$xxx = $box->show("table");

$dbq->delete("uname='$usr'");

?>
