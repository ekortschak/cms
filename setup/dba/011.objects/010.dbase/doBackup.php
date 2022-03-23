in Vorbereitung ...

<?php
return;

incCls("menus/dropbox.php");
incCls("dbase/dbAlter.php");

// ***********************************************************
// show menu
// ***********************************************************
$box = new dbox();
$erg = $box->showDBObjs("B"); extract($erg);
$dst = $box->getInput("destination", "$dbs.sql");
$xxx = $box->show("table");

// ***********************************************************
// ask for confirmation
// ***********************************************************
HTM::tag("dbs.backup");

$ddl = new dbAlter($dbs, $tbl);
$ddl->db_backup($dbs, $dst);

?>
