<?php

incCls("menus/dropbox.php");
incCls("dbase/dbAlter.php");

// ***********************************************************
// show menu
// ***********************************************************
$box = new dbox();
$erg = $box->showDBObjs("X"); extract($erg);
$neu = $box->getInput("dbs.new", "new_database");
$xxx = $box->show("table");

// ***********************************************************
// ask for confirmation
// ***********************************************************
HTM::tag("dbs.create");

$ddl = new dbAlter($dbs, $tbl);
$ddl->db_add($neu);

?>
