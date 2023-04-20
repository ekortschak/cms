<?php

if (isset($_GET["layout"])) define("LAYOUT", $_GET["layout"]);

// ***********************************************************
// load working dirs
// ***********************************************************
include_once "config/fallback.php";

if (! is_dir(APP_FBK)) die("APP_FBK not set correctly: ".APP_FBK);
if (! is_dir(APP_DIR)) die("APP_DIR not set correctly: ".APP_DIR);

require_once("include/funcs.php");

// ***********************************************************
// load basic classes (mostly static)
// ***********************************************************
incCls("system/STR.php"); // basic string functions
incCls("system/APP.php"); // app specific functions
incCls("system/FSO.php"); // basic dir functions
incCls("system/VEC.php"); // basic vector functions

// ***********************************************************
// read config file(s)
// ***********************************************************
incFnc("constants.php");

incCls("system/CFG.php"); // prepare constants
CFG::setIf("layout");

// ***********************************************************
// start session
// ***********************************************************
incCls("system/SSV.php"); // session vars

// ***********************************************************
// create css output
// ***********************************************************
incCls("files/css.php");

$css = new css();
$css->get();

?>
