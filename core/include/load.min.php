<?php

if (! is_dir(APP_FBK)) die("APP_FBK not set correctly: ".APP_FBK);
if (! is_dir(APP_DIR)) die("APP_DIR not set correctly: ".APP_DIR);

include_once("internals.php");  // internal constants
require_once("funcs.php");

// ***********************************************************
// load basic classes (mostly static)
// ***********************************************************
incCls("objects.php");

incCls("system/TMR.php");   // start timer
incCls("system/STR.php");   // basic string functions
incCls("system/VEC.php");   // basic array functions
incCls("system/FSO.php");   // basic dir functions
incCls("system/APP.php");   // app specific functions
incCls("system/CHK.php");   // basic validation functions

incCls("files/iniCfg.php"); // basic ini handler

// ***********************************************************
// set environment
// ***********************************************************
incCls("system/CFG.php");   // prepare constants
incCls("system/SSV.php");   // session vars
incCls("system/ENV.php");   // session & env vars
incCls("system/OID.php");   // object IDs

incCls("system/LOC.php");   // basic dir functions
incCls("server/NET.php");   // net info

#APP::addPath(APP_ROOT);
APP::addPath(DOC_ROOT);

// ***********************************************************
// debugging tools
// ***********************************************************
incCls("system/DBG.php");   // debugging tools
incCls("system/LOG.php");   // logging tools

// ***********************************************************
// benchmark
// ***********************************************************
# TMR::punch("inc.min");

?>
