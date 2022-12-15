in Vorbereitung ...

<?php
return;

incCls("menus/dropbox.php");
incCls("dbase/dbAlter.php");
incCls("input/selector.php");

// ***********************************************************
// show menu
// ***********************************************************
$box = new dbox();
$erg = $box->showDBObjs("B"); extract($erg);
$xxx = $box->show("menu");

$sel = new selector();
$new = $sel->input("act.rename", $dbs."_old");
$act = $sel->show();

// ***********************************************************
// ask for confirmation
// ***********************************************************
HTM::tag("dbs.rename");

$ddl = new dbAlter($dbs, $tbl);
$ddl->db_rename($dbs, $new);

?>
