<?php

incCls("editor/iniMgr.php");

// ***********************************************************
// read and write data
// ***********************************************************
$mgr = new iniMgr("css.dims.def");
$mgr->setFile(LOC_DIM, "Layout", "default.ini");
$mgr->edit();

?>
