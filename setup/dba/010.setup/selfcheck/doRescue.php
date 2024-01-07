<?php

incCls("menus/dropDbo.php");
incCls("input/confirm.php");

// ***********************************************************
// show menu
// ***********************************************************
$box = new dropDbo();
$dbs = $box->getDbase();
$xxx = $box->show();

if (! $dbs) return;

// ***********************************************************
// ask for confirmation
// ***********************************************************
$cnf = new confirm();
$cnf->dic("dbo.sanitize");
$cnf->add("&rarr; Datenbank = $dbs");
$cnf->show();

if (! $cnf->act()) return;

// ***********************************************************
// create standard objects
// ***********************************************************
APP::inc(__DIR__, "exObjs.php");
APP::inc(__DIR__, "exPrivs.php");
APP::inc(__DIR__, "exAdmin.php");

?>
