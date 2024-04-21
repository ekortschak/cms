<?php

// ***********************************************************
// load essential modules
// ***********************************************************
include_once "include/load.err.php";
include_once "include/load.min.php";
include_once "include/load.more.php";
include_once "include/load.dbs.php";

include_once "include/load.ini.php"; // php settings

// ***********************************************************
// overruling vmode
// ***********************************************************
$mod = ENV::getVMode();

if (STR::contains($mod, "edit")) $mod = "view";
if (STR::features($mod, "seo"))  $mod = "view";

CFG::set("VMODE", $mod);

// ***********************************************************
// create page
// ***********************************************************
include_once "include/pagemaker.php";

?>
