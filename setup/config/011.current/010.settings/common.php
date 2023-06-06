<?php

incCls("editor/iniMgr.php");

// ***********************************************************
// save modifications
// ***********************************************************
// effected by saveCfg.php

// ***********************************************************
// read and write data
// ***********************************************************
$mgr = new iniMgr("$fcs.def");
$mgr->read("config/$fcs.ini");
$mgr->setScope();
$mgr->edit();

?>
