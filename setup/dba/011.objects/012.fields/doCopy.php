<?php

incCls("menus/dropbox.php");
incCls("dbase/dbInfo.php");
incCls("dbase/dbAlter.php");

// ***********************************************************
// show menu and options
// ***********************************************************
$fnc = array(
	"f_copy"  => "copy",
	"f_merge" => "merge"
);

$box = new dbox();
$ret = $box->showDBObjs("BTF"); extract($ret);

$dbi = new dbInfo($dbs, $tbl);
$arr = $dbi->fields($tbl, "%", $fld); unset($arr["ID"]);

$dst = $box->getKey("copy.to", $arr);
$fnc = $box->getKey("method", $fnc);
$xxx = $box->show("table");

// ***********************************************************
// ask for confirmation
// ***********************************************************
HTM::tag("fld.copy");

$ddl = new dbAlter($dbs, $tbl);
$ddl->$fnc($tbl, $fld, $dst);

?>
