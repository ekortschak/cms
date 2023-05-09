<?php

incCls("editor/iniMgr.php");
incCls("server/ftp.php");

// ***********************************************************
// read and write data
// ***********************************************************
$ini = new iniMgr("LOC_CFG/ftp.def");
$ini->getScope(false);
$ini->show("config/ftp.ini");

// ***********************************************************
HTW::xtag("ftp.check");
// ***********************************************************
$ftp = new ftp();
$chk = $ftp->test();

?>
