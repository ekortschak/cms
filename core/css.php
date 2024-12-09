<?php

// ***********************************************************
// load basic constants and functions
// ***********************************************************
require_once "include/fallback.php";
require_once "include/internals.php";
require_once "include/funcs.php";
require_once "include/SYS.php";

define("SSHEET", SYS::get("style", "1.75rem"));
define("P_SIZE", SYS::get("fsize", "1.75rem"));

// ***********************************************************
// load basic classes (mostly static)
// ***********************************************************
incCls("system/STR.php"); // basic string functions
incCls("system/VEC.php"); // basic vector functions
#ncCls("system/PRG.php"); // basic regex functions
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
qwreqwerqWx
