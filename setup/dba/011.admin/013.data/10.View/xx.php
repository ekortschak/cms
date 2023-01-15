<?php

incCls("menus/dropDbo.php");
incCls("dbase/tblMgr.php");

// ***********************************************************
// show menu
// ***********************************************************
$box = new dropDbo();
$dbs = $box->getDbase();
$tbl = $box->getTable($dbs);
$fld = $box->getFilter($dbs, $tbl);
$xxx = $box->show();

// ***********************************************************
// show data
// ***********************************************************
$few = new tblMgr($dbs, $tbl);
$few->addFilter($fld);
$few->permit("w");
$few->show();

?>
