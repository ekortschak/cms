<?php

// ***********************************************************
// read and write data
// ***********************************************************
$mgr = new iniMgr("dbase.def");
$mgr->read("config/dbase.ini");
$mgr->setScope();
$mgr->edit();

// ***********************************************************
HTW::xtag("dbo.check objects");
// ***********************************************************
$sts = CFG::dbState();

if ($sts == "nodb")  return MSG::now("db.missing");
if ($sts == "nocon") return MSG::now("db.con");

MSG::now("db.con ok");

?>
