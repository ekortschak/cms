<?php

error_reporting(E_ALL);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

define("ERR_SHOW", 1);

// ***********************************************************
// load essential modules
// ***********************************************************
include_once "config/fallback.php";

include_once "core/include/load.min.php";
include_once "core/include/load.more.php";

// ***********************************************************
// local execution only
// ***********************************************************
if (! IS_LOCAL) die("Thanks for stopping by ...");

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
<hr>
Still alive ...
