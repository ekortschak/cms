<?php

incCls("menus/dropDbo.php");
incCls("dbase/dbAlter.php");

// ***********************************************************
// show menu
// ***********************************************************
$mod = array(
	"ASC"  => "Ascending",
	"DESC" => "Descending"
);

$box = new dropDbo();
$dbs = $box->getDbase();
$tbl = $box->getTable($dbs);
$fld = $box->getField($dbs, $tbl);
$xxx = $box->show();

// ***********************************************************
HTW::xtag("tbl.sort");
// ***********************************************************
$box = new dropBox("table");
$mod = $box->getKey("sort.by", $mod);
$xxx = $box->show();

// ***********************************************************
// ask for confirmation
// ***********************************************************
$ddl = new dbAlter($dbs, $tbl);
$ddl->t_sort($tbl, $fld, $mod);

?>
