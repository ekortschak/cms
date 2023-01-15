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
$dir = APP::relPath(__DIR__);

include_once("$dir/exObjs.php");
include_once("$dir/exPrivs.php");
include_once("$dir/exAdmin.php");

?>
