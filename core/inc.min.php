<?php

if (! is_dir(APP_FBK)) die("APP_FBK not set correctly: ".APP_FBK);
if (! is_dir(APP_DIR)) die("APP_DIR not set correctly: ".APP_DIR);

// ***********************************************************
// start the session
// ***********************************************************
session_start();

require_once("funcs.php");

incCls("system/LOG.php"); // logging tools
incCls("system/DBG.php"); // debugging tools

// ***********************************************************
// load basic classes (mostly static)
// ***********************************************************
incCls("objects.php");	  // base class

incCls("system/STR.php"); // basic string functions
incCls("system/CHK.php"); // basic validation functions
incCls("system/DAT.php"); // basic date functions
incCls("system/VEC.php"); // basic array functions
incCls("system/LNG.php"); // language support
incCls("system/APP.php"); // app specific functions
incCls("system/FSO.php"); // basic dir functions

incCls("server/SSL.php"); // string encryption

// ***********************************************************
// read config file(s)
// ***********************************************************
incCls("system/KONST.php");	// prepare constants

$arr = FSO::files("config/*.ini");

foreach ($arr as $fil => $nam) {
	KONST::read($fil);
}

// ***********************************************************
// create environment
// ***********************************************************
incCls("system/ENV.php"); // session & env vars

// ***********************************************************
// provide default values for constants
// ***********************************************************
KONST::read("design/config/defaults.ini");
KONST::roundup();

?>
