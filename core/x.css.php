<?php

$stl = "default"; if (isset($_GET["style"])) $stl = $_GET["style"];
$fsz = "1rem";    if (isset($_GET["fsize"])) $fsz = $_GET["fsize"];

define("SSHEET", $stl);
define("F_SIZE", $fsz);

// ***********************************************************
// load working dirs
// ***********************************************************
require_once "include/fallback.php";
require_once "include/internals.php";
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

// ***********************************************************
// create css output
// ***********************************************************
incCls("files/css.php");

$css = new css();
$css->get();

?>
