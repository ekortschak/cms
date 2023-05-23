<?php

incCls("editor/iniMgr.php");

// ***********************************************************
// read and write data
// ***********************************************************
$mgr = new iniMgr("css.dims.def");
$mgr->setFile(LOC_LAY, "Layout", "default.ini");
$mgr->edit();

?>
