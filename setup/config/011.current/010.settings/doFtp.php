<?php

incCls("editor/iniMgr.php");

// ***********************************************************
// read and write data
// ***********************************************************
$fil = "config/ftp.ini";
incCls("server/ftp.php");

HTW::tag("file = $fil", "small");

$ini = new iniMgr("LOC_CFG/ftp.ini");
$ini->update($fil);
$ini->show();

// ***********************************************************
HTW::xtag("ftp.check");
// ***********************************************************
$ftp = new ftp();
$chk = $ftp->test();

?>
