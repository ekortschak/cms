<?php

incCls("editor/iniMgr.php");
incCls("server/ftp.php");

// ***********************************************************
// read and write data
// ***********************************************************
$mgr = new iniMgr("ftp.def");
$mgr->setScope(false);
$mgr->edit("config/ftp.ini");

// ***********************************************************
HTW::xtag("ftp.check");
// ***********************************************************
$ftp = new ftp();
$chk = $ftp->test();

?>
