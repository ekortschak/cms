<?php

incCls("objects.php");	  // base class

// ***********************************************************
// load general classes
// ***********************************************************
incCls("user/USR.php");	   // user info, login

incCls("system/REG.php");  // register js & css files
incCls("system/DIC.php");  // language support
incCls("system/MSG.php");  // messaging
incCls("system/ERR.php");  // error handling

incCls("system/PRG.php");  // more string functions
incCls("system/HTM.php");  // basic html objects
incCls("system/HTW.php");  // basic html objects
incCls("system/PGE.php");  // tab and page info

incCls("files/tpl.php");   // base template class
incCls("files/code.php");  // reading editable files
incCls("files/ini.php");   // handling ini files
incCls("files/page.php");  // xform layout to page

incCls("server/NET.php");  // network tools

// ***********************************************************
// db support
// ***********************************************************
include_once "core/inc.dbs.php";

// ***********************************************************
// read config files
// ***********************************************************
CFG::readCfg();

// ***********************************************************
// load local constants and classes (if any)
// ***********************************************************
$lcl = "core/include/locals.php";
if (is_file($lcl)) include_once $lcl;

// ***********************************************************
// benchmark
// ***********************************************************
TMR::punch("inc.more");

?>
