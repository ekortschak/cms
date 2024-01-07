<?php

// ***********************************************************
// load essential modules
// ***********************************************************
include_once "include/load.err.php";
include_once "include/load.min.php";
include_once "include/load.more.php";
include_once "include/load.ini.php"; // php settings

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
	case "offline": case "opts": case "search":
	case "pres":    case "xfer": case "toc":
	case "print":   case "csv":  break;
	default: $mod = "view"; // deny editing
}

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
