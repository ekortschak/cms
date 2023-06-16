<?php

if (! isset($local)) {
	$local = false;
}

// ***********************************************************
// deny editing
// ***********************************************************
if (isset(  $_GET["vmode"])) {
	switch ($_GET["vmode"]) {
		case "search": case "xfer": break;
		default: $_GET["vmode"] = "view";
	}
}

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
if ($local) if (! IS_LOCAL) {
	die("Thanks for stopping by ...");
}

// ***********************************************************
// supply defaults
// ***********************************************************
include_once "include/load.ini.php";
include_once "include/load.std.php";

// ***********************************************************
// create page
// ***********************************************************
incFnc("pagemaker.php");

?>
