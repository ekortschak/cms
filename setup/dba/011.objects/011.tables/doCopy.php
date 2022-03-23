<?php

incCls("menus/dropbox.php");
incCls("dbase/dbAlter.php");

// ***********************************************************
// show menu
// ***********************************************************
$box = new dbox();
$erg = $box->showDBObjs("BT"); extract($erg);
$neu = $box->getInput("tbl.new", $tbl."_bkp");
$xxx = $box->show("table");

// ***********************************************************
// ask for confirmation
// ***********************************************************
HTM::tag("tbl.copy");

$ddl = new dbAlter($dbs, $tbl);
$ddl->t_copy($tbl, $neu);

?>
