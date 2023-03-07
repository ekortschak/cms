<?php

incCls("menus/dropDbo.php");
incCls("dbase/recFilter.php");
incCls("dbase/dbQuery.php");

$box = new dropDbo();
$dbs = $box->getDbase();
$xxx = $box->show();

// ***********************************************************
// show filter
// ***********************************************************
$sel = new recFilter($dbs, "dbusr"); // filter
$xxx = $sel->addFilter("uname");
$flt = $sel->getFilter();

$dbq = new dbQuery($dbs, "dbusr");
$lst = $dbq->getDVs("uname", $flt);

if (! $lst) {
	return MSG::now("tbl.empty", "dbusr");
}

// ***********************************************************
HTW::xtag("usr.drop");
// ***********************************************************
$box = new dropBox();
$usr = $box->getKey("user", $lst);
$xxx = $box->show();

$dbq->delete("uname='$usr'");

?>
