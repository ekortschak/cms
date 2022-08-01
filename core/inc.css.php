<?php

/* this file contains minimum requirements
 * as needed for x.css.php and others
 */

if (! is_dir(APP_FBK)) die("APP_FBK not set correctly: ".APP_FBK);
if (! is_dir(APP_DIR)) die("APP_DIR not set correctly: ".APP_DIR);

// ***********************************************************
// load basic classes (mostly static)
// ***********************************************************
include("core/classes/objects.php");    // base class
include("core/classes/system/STR.php"); // basic string functions
include("core/classes/system/PRG.php"); // regex
include("core/classes/system/APP.php"); // app specific functions
include("core/classes/system/FSO.php"); // basic dir functions
include("core/classes/system/VEC.php"); // basic vector functions

include("core/classes/files/css.php");  // css

// ***********************************************************
// read config file(s)
// ***********************************************************
include("core/classes/system/CFG.php"); // prepare constants

CFG::check("layout");

CFG::read("config/config.ini");
CFG::read("design/config/defaults.ini");
CFG::read("design/colors/COLORS.ini");
CFG::read("design/layout/LAYOUT.ini");

#CFG::read("design/config/defaults.ini");

?>
