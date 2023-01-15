<?php

incCls("menus/dropDbo.php");
incCls("dbase/dbAlter.php");

// ***********************************************************
// show menu
// ***********************************************************
$fnc = array(
	"t_trunc" => "TRUNCATE (delete data only)",
	"t_drop" => "DROP (remove table completely)"
);

$box = new dropDbo();
$dbs = $box->getDbase();
$tbl = $box->getTable($dbs);
$xxx = $box->show();

// ***********************************************************
HTW::xtag("tbl.drop");
// ***********************************************************
$box = new dropBox();
$fnc = $box->getKey("method", $fnc);
$xxx = $box->show();

// ***********************************************************
// ask for confirmation
// ***********************************************************
$ddl = new dbAlter($dbs, $tbl);

if ($fnc == "t_trunc") {
	HTW::xtag("tbl.trunc");
	$ddl->t_trunc($tbl);
}
else {
	HTW::xtag("tbl.drop");
	$ddl->t_drop($tbl);
}

?>
