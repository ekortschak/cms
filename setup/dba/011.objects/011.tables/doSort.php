<?php

incCls("menus/dropbox.php");
incCls("dbase/dbAlter.php");

// ***********************************************************
// show menu
// ***********************************************************
$mod = array(
	"ASC"  => "Ascending",
	"DESC" => "Descending"
);

$box = new dbox();
$ret = $box->showDBObjs("BTF"); extract($ret);
$mod = $box->getKey("sort.by", $mod);
$xxx = $box->show("table");

// ***********************************************************
// ask for confirmation
// ***********************************************************
HTM::tag("tbl.sort");

$ddl = new dbAlter($dbs, $tbl);
$ddl->t_sort($tbl, $fld, $mod);

?>
