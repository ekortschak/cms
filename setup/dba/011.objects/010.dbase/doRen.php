in Vorbereitung ...

<?php
return;

incCls("menus/dboBox.php");
incCls("dbase/dbAlter.php");
incCls("input/selector.php");

// ***********************************************************
// show menu
// ***********************************************************
$box = new dboBox();
$dbs = $box->getDbase();
$xxx = $box->show();

$sel = new selector();
$new = $sel->input("act.rename", $dbs."_old");
$act = $sel->show();

// ***********************************************************
HTW::xtag("dbs.rename"); // ask for confirmation
// ***********************************************************
$ddl = new dbAlter($dbs, $tbl);
$ddl->db_rename($dbs, $new);

?>
