<?php

// ***********************************************************
// load general classes
// ***********************************************************
incCls("system/REG.php"); // register js & css files
incCls("system/LNG.php"); // language support
incCls("system/DIC.php"); // language support
incCls("system/MSG.php"); // messaging
incCls("system/ERR.php"); // error handling

incCls("system/PRG.php"); // more string functions
incCls("system/HTM.php"); // basic html objects
incCls("system/HTW.php"); // basic html objects
incCls("system/PGE.php"); // tab and page info

incCls("files/tpl.php");  // base template class
incCls("files/code.php"); // reading ini files and templates
incCls("files/ini.php");  // handling ini files

incCls("editor/ACR.php"); // transforming acronyms

// ***********************************************************
// user support
// ***********************************************************
incCls("user/USR.php");	  // user info, login

// ***********************************************************
// benchmark
// ***********************************************************
# TMR::punch("inc.more");

?>
