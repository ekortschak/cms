in Vorbereitung ...

<?php
return;

incCls("menus/localMenu.php");
incCls("input/selector.php");
incCls("dbase/dbAlter.php");

// ***********************************************************
// show menu
// ***********************************************************
$box = new localMenu();
$erg = $box->showDBObjs("B"); extract($erg);
$xxx = $box->show("menu");

$sel = new selector();
$dst = $sel->input("destination", "$dbs.sql");
$act = $sel->show();

// ***********************************************************
// ask for confirmation
// ***********************************************************
HTM::tag("dbs.backup");

$ddl = new dbAlter($dbs, $tbl);
$ddl->db_backup($dbs, $dst);

?>
