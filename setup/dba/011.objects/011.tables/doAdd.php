<?php

incCls("menus/dropbox.php");
incCls("dbase/dbAlter.php");

// ***********************************************************
// show menu
// ***********************************************************
$box = new dbox();
$erg = $box->showDBObjs("BN"); extract($erg);
$neu = $box->getInput("tbl.new", "new_table");
$xxx = $box->show("table");

// ***********************************************************
// ask for confirmation
// ***********************************************************
HTM::tag("tbl.create");

$ddl = new dbAlter($dbs, $tbl);
$ddl->t_add($neu);

?>

