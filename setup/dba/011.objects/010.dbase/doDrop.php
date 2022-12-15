<?php

incCls("menus/qikSelect.php");
incCls("dbase/dbAlter.php");

// ***********************************************************
// show menu
// ***********************************************************
$box = new qikSelect();
$erg = $box->showDBObjs("B"); extract($erg);
$xxx = $box->show("menu");

// ***********************************************************
// ask for confirmation
// ***********************************************************
HTM::tag("dbs.drop");

$ddl = new dbAlter($dbs, $tbl);
$ddl->db_drop($dbs);

?>
