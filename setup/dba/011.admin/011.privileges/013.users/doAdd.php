<?php

incCls("dbase/recEdit.php");
incCls("menus/dropDbo.php");

$box = new dropDbo();
$dbs = $box->getDbase();
$xxx = $box->show();

// ***********************************************************
HTW::xtag("usr.create");
// ***********************************************************
$dbe = new recEdit($dbs, "dbusr");
$dbe->findRec();
$dbe->permit("a");
$dbe->show();

?>
