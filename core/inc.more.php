<?php

ob_start();

// ***********************************************************
// load general classes
// ***********************************************************
incCls("user/USR.php");	   // user info, login

incCls("system/REG.php");  // register js & css files
incCls("system/DIC.php");  // language support
incCls("system/MSG.php");  // messaging

incCls("system/PRG.php");  // more string functions
incCls("system/HTM.php");  // basic html objects
incCls("system/HTW.php");  // basic html objects

incFnc("error.php");	   // error settings
incCls("system/ERR.php");  // error handling
incCls("system/PGE.php");  // tab info

incCls("files/tpl.php");   // base template class
incCls("files/code.php");  // reading editable files
incCls("files/ini.php");   // handling ini files
incCls("files/page.php");  // xform layout to page

incCls("server/NET.php");  // network tools

// ***********************************************************
// db support
// ***********************************************************
include("core/inc.dbs.php");

// ***********************************************************
// execute pending fs modifications
// ***********************************************************
incCls("editor/ACT.php");  // modifications to project

CFG::readCfg();

// ***********************************************************
// load local classes (if any)
// ***********************************************************
$lcl = "core/include/locals.php";
if (is_file($lcl)) include_once $lcl;

// ***********************************************************
// log generated output
// ***********************************************************
$msg = ob_get_clean();

LOG::total("config done");
LOG::append($msg);

?>
