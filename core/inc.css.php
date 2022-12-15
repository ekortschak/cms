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

include_once("core/classes/system/STR.php"); // basic string functions
include_once("core/classes/system/APP.php"); // app specific functions
include_once("core/classes/system/FSO.php"); // basic dir functions
include_once("core/classes/system/VEC.php"); // basic vector functions

// ***********************************************************
// read config file(s)
// ***********************************************************
include_once("core/classes/system/CFG.php"); // prepare constants

CFG::setIf("layout");

CFG::read("config/config.ini");
CFG::read("design/config/defaults.ini");
CFG::read("design/colors/COLORS.ini");
CFG::read("design/layout/LAYOUT.ini");

// ***********************************************************
include_once("core/classes/system/SSV.php"); // session vars
include_once("core/classes/files/css.php");  // css

?>
