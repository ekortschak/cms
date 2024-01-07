<?php

# define("LAYOUT", "default");

// ***********************************************************
// load essential modules
// ***********************************************************
require_once "include/fallback.php";
include_once "include/load.err.php";
include_once "include/load.min.php";
include_once "include/load.more.php";

// ***********************************************************
// require login
// ***********************************************************
requireAdmin();

if (! FS_ADMIN) CFG::set("VMODE", "login");

// ***********************************************************
// setting VMODE and CUR_DEST
// ***********************************************************
$mod = ENV::getVMode();

CFG::set("VMODE", $mod);
CFG::setDest(VMODE);

// ***********************************************************
// supply app specific features
// ***********************************************************
$fil = appFile("core/include/load.app.php");
include_once $fil;

// ***********************************************************
// create page
// ***********************************************************
include_once "include/defaults.php"; // handle missing constants
include_once "include/pagemaker.php";

?>
