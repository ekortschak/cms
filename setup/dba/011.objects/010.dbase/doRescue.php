<?php

incCls("menus/dropbox.php");

// ***********************************************************
// show menu
// ***********************************************************
$box = new dbox();
$erg = $box->showDBObjs("B"); extract($erg);
$xxx = $box->show("menu");

// ***********************************************************
// ask for confirmation
// ***********************************************************
$cnf = new confirm();
$cnf->dic("dba.sanitize");
$cnf->add("&rarr; $dbs");
$cnf->show();

if (! $cnf->act()) return;

// ***********************************************************
// create standard objects
// ***********************************************************
$dir = FSO::mySep(__DIR__);

include_once("$dir/exObjs.php");
include_once("$dir/exPrivs.php");
include_once("$dir/exAdmin.php");

?>