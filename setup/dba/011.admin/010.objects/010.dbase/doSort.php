<?php

incCls("menus/dboBox.php");
incCls("dbase/dbAlter.php");

// ***********************************************************
// show menu
// ***********************************************************
$mod = array(
	"ASC"  => "Ascending",
	"DESC" => "Descending"
);

$box = new dboBox();
$dbs = $box->getDbase();
$tbl = $box->getTable($dbs);
$fld = $box->getField($dbs, $tbl);
$xxx = $box->show();

$mod = $box->getKey("sort.by", $mod);
$xxx = $box->show();

// ***********************************************************
// ask for confirmation
// ***********************************************************
HTW::xtag("tbl.sort");

$ddl = new dbAlter($dbs, $tbl);
$ddl->t_sort($tbl, $fld, $mod);

?>
