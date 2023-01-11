<?php

incCls("menus/dboBox.php");
incCls("dbase/tblMgr.php");

$box = new dboBox();
$dbs = $box->getDbase();
$xxx = $box->show();

// ***********************************************************
HTW::xtag("usr.edit");
// ***********************************************************
$few = new tblMgr($dbs, "dbusr");
$few->addFilter("uname");
$few->hide("pwd, acticode, tstamp, country");
$few->permit("w");
$few->show();

?>
