<?php

# define("LAYOUT", "default");

// ***********************************************************
// load essential modules
// ***********************************************************
include_once "config/fallback.php";

include_once "include/load.err.php";
include_once "include/load.min.php";
include_once "include/load.more.php";

// ***********************************************************
// require login
// ***********************************************************
requireAdmin();

if (! FS_ADMIN) CFG::set("VMODE","login");

// ***********************************************************
// setting VMODE and CUR_DEST
// ***********************************************************
$mod = ENV::getVMode();

CFG::set("VMODE", $mod);
CFG::setDest(VMODE);

// ***********************************************************
// supply defaults
// ***********************************************************
include_once "include/load.app.php";
include_once "defaults.php";

// ***********************************************************
// create page
// ***********************************************************
incFnc("pagemaker.php");

?>
