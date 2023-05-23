<?php

if (! is_dir(APP_FBK)) die("APP_FBK not set correctly: ".APP_FBK);
if (! is_dir(APP_DIR)) die("APP_DIR not set correctly: ".APP_DIR);

require_once("funcs.php");

// ***********************************************************
// load basic classes (mostly static)
// ***********************************************************
incCls("system/TMR.php"); // start timer

incCls("system/STR.php"); // basic string functions
incCls("system/LNG.php"); // language support
incCls("system/VEC.php"); // basic array functions
incCls("system/FSO.php"); // basic dir functions
incCls("system/APP.php"); // app specific functions
incCls("system/CHK.php"); // basic validation functions

// ***********************************************************
// set environment
// ***********************************************************
incFnc("constants.php");  // set preliminary constants

incCls("server/NET.php"); // net info
incCls("system/CFG.php"); // prepare constants
incCls("system/SSV.php"); // session vars
incCls("system/ENV.php"); // session & env vars
incCls("system/OID.php"); // object IDs

// ***********************************************************
// debugging tools
// ***********************************************************
incCls("system/DBG.php"); // debugging tools
incCls("system/LOG.php"); // logging tools

// ***********************************************************
// benchmark
// ***********************************************************
# TMR::punch("inc.min");

?>
