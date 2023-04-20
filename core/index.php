<?php

// ***********************************************************
// deny editing
// ***********************************************************
if (isset(  $_GET["vmode"])) {

	switch ($_GET["vmode"]) {
		case "search": break;
		case "xfer":   break;

#			default: $_GET["vmode"] = "view";
	}
}

// ***********************************************************
// load essential modules
// ***********************************************************
include_once "config/fallback.php";
include_once "include/load.min.php";
include_once "include/load.more.php";

// ***********************************************************
// create page
// ***********************************************************
incFnc("pagemaker.php");

?>
