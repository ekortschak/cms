<?php

incCls("menus/dboBox.php");
incCls("menus/qikSelect.php");
incCls("dbase/tblFilter.php");
incCls("dbase/dbQuery.php");

$box = new dboBox();
$dbs = $box->getDbase();
$xxx = $box->show();

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

$box = new qikSelect();
$usr = $box->getKey("user", $lst);
$xxx = $box->show();

$dbq->delete("uname='$usr'");

?>
