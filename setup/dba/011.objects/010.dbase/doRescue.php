<?php

incCls("menus/dboBox.php");
incCls("input/confirm.php");

// ***********************************************************
// show menu
// ***********************************************************
$box = new dboBox();
$dbs = $box->getDbase();
$xxx = $box->show();

// ***********************************************************
// info
// ***********************************************************
HTW::tag("Check CMS requirements");
HTW::tag("This will recreate missing tables and fields.", "p");

// ***********************************************************
// ask for confirmation
// ***********************************************************
$cnf = new confirm();
$cnf->dic("dbo.sanitize");
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
