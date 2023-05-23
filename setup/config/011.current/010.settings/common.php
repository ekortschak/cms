<?php

incCls("editor/iniMgr.php");

// ***********************************************************
// read and write data
// ***********************************************************
$mgr = new iniMgr("$fcs.def");
$mgr->read("config/$fcs.ini");
$mgr->setScope();
$mgr->edit();

?>
