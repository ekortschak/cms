<?php

incCls("menus/dboBox.php");
incCls("dbase/dbAlter.php");

// ***********************************************************
// show menu
// ***********************************************************
$box = new dboBox();
$dbs = $box->getDbase();
$tbl = $box->getTable($dbs);
$fld = $box->getField($dbs, $tbl);
$xxx = $box->show();

// ***********************************************************
HTW::xtag("fld.drop"); // ask for confirmation
// ***********************************************************
$ddl = new dbAlter($dbs, $tbl);
$ddl->f_drop($tbl, $fld);

?>
