<?php

incCls("menus/dropbox.php");
incCls("dbase/tblMgr.php");

$box = new dbox();
$erg = $box->showDBObjs("B"); extract($erg);
$xxx = $box->show("menu");

// ***********************************************************
// show corresponding records
// ***********************************************************
$few = new tblMgr($dbs, "dbusr");
$few->addFilter("uname");
$few->hide("pwd, acticode, tstamp, country");
$few->permit("w");
$few->show();

?>
