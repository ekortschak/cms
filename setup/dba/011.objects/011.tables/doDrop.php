<?php

incCls("menus/qikSelect.php");
incCls("dbase/dbAlter.php");

// ***********************************************************
// show menu
// ***********************************************************
$fnc = array(
	"t_trunc" => "TRUNCATE (delete data only)",
	"t_drop" => "DROP (remove table completely)"
);

$box = new qikSelect();
$erg = $box->showDBObjs("BT"); extract($erg);
$fnc = $box->getKey("method", $fnc);
$xxx = $box->show();

// ***********************************************************
// ask for confirmation
// ***********************************************************
$ddl = new dbAlter($dbs, $tbl);

if ($fnc == "t_trunc") {
	HTM::tag("tbl.trunc");
	$ddl->t_trunc($tbl);
}
else {
	HTM::tag("tbl.drop");
	$ddl->t_drop($tbl);
}

?>
