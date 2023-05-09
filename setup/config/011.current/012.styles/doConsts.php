<?php

incCls("editor/iniMgr.php");

// ***********************************************************
// read and write data
// ***********************************************************
$ini = new iniMgr("LOC_CFG/css.dims.def");
$fil = $ini->getFile(LOC_LAY, "Layout", "default.ini");
$xxx = $ini->show($fil);

?>
