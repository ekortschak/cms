<?php

/* this file contains minimum requirements
 * as needed for x.css.php and others
 */

if (! is_dir(APP_FBK)) die("APP_FBK not set correctly: ".APP_FBK);
if (! is_dir(APP_DIR)) die("APP_DIR not set correctly: ".APP_DIR);

// ***********************************************************
// load basic classes (mostly static)
// ***********************************************************
require_once("funcs.php");

incCls("system/STR.php"); // basic string functions
incCls("system/APP.php"); // app specific functions
incCls("system/FSO.php"); // basic dir functions
incCls("system/VEC.php"); // basic vector functions

// ***********************************************************
// read config file(s)
// ***********************************************************
include_once "core/include/preset.php";

incCls("system/CFG.php"); // prepare constants
CFG::setIf("layout");

// ***********************************************************
incCls("system/SSV.php"); // session vars
incCls("files/css.php");

?>
