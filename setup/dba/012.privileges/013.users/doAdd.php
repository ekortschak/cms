<?php

incCls("dbase/recEdit.php");
incCls("menus/dropbox.php");

$box = new dbox();
$erg = $box->showDBObjs("B"); extract($erg);

// ***********************************************************
HTM::tag("usr.create");

$dbe = new recEdit($dbs, "dbusr");
$dbe->findRec();
$dbe->permit("a");
$dbe->show();

?>
