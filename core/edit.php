<?php

// ***********************************************************
// load essential modules
// ***********************************************************
include_once "include/load.err.php";
include_once "include/load.min.php";
include_once "include/load.more.php";
include_once "include/load.dbs.php";

SYS::forceAdmin();

// ***********************************************************
// setting VMODE
// ***********************************************************
$mod = ENV::vmode(); if (! FS_ADMIN)
$mod = "login";

CFG::set("VMODE", $mod);

// ***********************************************************
// create page
// ***********************************************************
include_once "include/pagemaker.php";

?>
