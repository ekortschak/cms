<?php

if (! is_dir(APP_FBK)) die("APP_FBK not set correctly: ".APP_FBK);
if (! is_dir(APP_DIR)) die("APP_DIR not set correctly: ".APP_DIR);

define("ICONS",   "core/icons");
define("LOC_DIC", "design/dictionary");
define("LOC_LAY", "design/layout");
define("LOC_CSS", "design/styles");
define("LOC_CFG", "design/config");
define("LOC_TPL", "design/templates");
define("LOC_BTN", "design/buttons");

define("LOC_LOG",  SRV_ROOT."/cms.log");

// ***********************************************************
// start the session
// ***********************************************************
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
// set environment
// ***********************************************************
incCls("system/CFG.php"); // prepare constants
incCls("system/SSV.php"); // session vars
incCls("system/ENV.php"); // session & env vars
incCls("system/OID.php"); // object IDs

?>
