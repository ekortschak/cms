<?php

// ***********************************************************
// read and write data
// ***********************************************************
$mgr = new iniMgr("config.def");
$mgr->read("config/config.ini");
$mgr->setScope();
$mgr->edit();

?>
