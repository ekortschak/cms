<?php

/* this file contains minimum requirements
 * as needed for x.css.php and others
 */

if (! is_dir(APP_FBK)) die("APP_FBK not set correctly: ".APP_FBK);
if (! is_dir(APP_DIR)) die("APP_DIR not set correctly: ".APP_DIR);

// ***********************************************************
// start the session
// ***********************************************************
require_once("funcs.php");

incCls("system/LOG.php");	// logging tools

// ***********************************************************
// load basic classes (mostly static)
// ***********************************************************
incCls("objects.php");		// base class

incCls("system/STR.php");	// basic string functions
incCls("system/preg.php");	// regex
incCls("system/APP.php"); 	// app specific functions
incCls("system/FSO.php"); 	// basic dir functions
incCls("system/VEC.php"); 	// basic dir functions

incCls("files/css.php");	// css

// ***********************************************************
// read config file(s)
// ***********************************************************
incCls("system/KONST.php");	// prepare constants

KONST::check("layout");

KONST::read("config/config.ini");
KONST::read("design/config/defaults.ini");
KONST::read("design/colors/COLORS.ini");
KONST::read("design/layout/LAYOUT.ini");
KONST::roundup();

?>
