<?php

if (isset($_GET["layout"])) {
	define("LAYOUT", $_GET["layout"]);
}

// ***********************************************************
// load working dirs
// ***********************************************************
require_once "include/fallback.php";
require_once "include/constants.php";
require_once "include/funcs.php";

// ***********************************************************
// load basic classes (mostly static)
// ***********************************************************
incCls("system/STR.php"); // basic string functions
incCls("system/VEC.php"); // basic vector functions
incCls("system/FSO.php"); // basic dir functions
incCls("system/APP.php"); // app specific functions

// ***********************************************************
// read config file(s)
// ***********************************************************
incCls("system/CFG.php"); // prepare constants
CFG::setIf("layout");

// ***********************************************************
// create css output
// ***********************************************************
incCls("files/css.php");

$css = new css();
$css->get();

?>
