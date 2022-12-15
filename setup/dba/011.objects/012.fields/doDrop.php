<?php

incCls("menus/dropbox.php");
incCls("dbase/dbAlter.php");

// ***********************************************************
// show menu
// ***********************************************************
$box = new dbox();
$ret = $box->showDBObjs("BTF"); extract($ret);
$xxx = $box->show("menu");

// ***********************************************************
// ask for confirmation
// ***********************************************************
HTM::tag("fld.drop");

$ddl = new dbAlter($dbs, $tbl);
$ddl->f_drop($tbl, $fld);

?>
