<?php

// ***********************************************************
// load essential modules
// ***********************************************************
include_once "config/fallback.php";

include_once "include/load.err.php";
include_once "include/load.min.php";
include_once "include/load.more.php";

// ***********************************************************
// check scope
// ***********************************************************
if (isset($local)) {
	if (! IS_LOCAL) die("Thanks for stopping by ...");
}

// ***********************************************************
// overruling vmode and dmode
// ***********************************************************
$mod = ENV::getVMode();

switch ($mod) {
	case "offline": case "toc": case "opts": case "search":
	case "xfer": break;
	default: $mod = "view"; // deny editing
}

CFG::set("VMODE", $mod);
CFG::setDest(VMODE);

// ***********************************************************
// supply defaults
// ***********************************************************
include_once "include/load.ini.php"; // php settings
include_once "include/load.app.php"; // app specific features
include_once "defaults.php";

// ***********************************************************
// create page
// ***********************************************************
incFnc("pagemaker.php");

?>
