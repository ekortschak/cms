<?php

incCls("editor/iniMgr.php");

// ***********************************************************
// read and write data
// ***********************************************************
$ini = new iniMgr("LOC_CFG/$fcs.def");
$ext = $ini->getScope();
$xxx = $ini->show("config/$fcs.$ext");

?>
