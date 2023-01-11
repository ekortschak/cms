<?php

incCls("menus/dboBox.php");
incCls("menus/qikSelect.php");
incCls("dbase/dbInfo.php");
incCls("dbase/dbAlter.php");

// ***********************************************************
// show menu and options
// ***********************************************************
$fnc = array(
	"f_copy"  => "copy",
	"f_merge" => "merge"
);

$box = new dboBox();
$dbs = $box->getDbase();
$tbl = $box->getTable($dbs);
$fld = $box->getField($dbs, $tbl);
$xxx = $box->show();

$dbi = new dbInfo($dbs, $tbl);
$arr = $dbi->fields($tbl, "%", $fld); unset($arr["ID"]);

// ***********************************************************
HTW::xtag("fld.copy");
// ***********************************************************
$box = new qikSelect();
$dst = $box->getKey("copy.to", $arr);
$fnc = $box->getKey("method", $fnc);
$xxx = $box->show();

// ***********************************************************
// ask for confirmation
// ***********************************************************

$ddl = new dbAlter($dbs, $tbl);
$ddl->$fnc($tbl, $fld, $dst);

?>
