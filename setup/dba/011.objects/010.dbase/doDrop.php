<?php

incCls("menus/dropbox.php");
incCls("dbase/dbAlter.php");

// ***********************************************************
// show menu
// ***********************************************************
$box = new dbox();
$erg = $box->showDBObjs("B"); extract($erg);
$xxx = $box->show("table");

// ***********************************************************
// ask for confirmation
// ***********************************************************
HTM::tag("dbs.drop");

$ddl = new dbAlter($dbs, $tbl);
$ddl->db_drop($dbs);

?>
