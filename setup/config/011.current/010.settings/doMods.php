<?php

// ***********************************************************
// read and write data
// ***********************************************************
$mgr = new iniMgr("mods.def");
$mgr->read("config/mods.ini");
$mgr->setScope();
$mgr->edit();

?>
