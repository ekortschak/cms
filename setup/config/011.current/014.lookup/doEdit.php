<?php

incCls("editor/iniMgr.php");

// ***********************************************************
// read and write data
// ***********************************************************
$ini = new iniMgr("LOC_CFG/lookup.def");
$fil = $ini->menu("lookup", "Lookup", "default.ini");
$xxx = $ini->show($fil);

?>
