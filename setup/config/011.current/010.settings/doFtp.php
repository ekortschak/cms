<?php

incCls("editor/iniMgr.php");

// ***********************************************************
// read and write data
// ***********************************************************
$fil = "config/ftp.ini";
incCls("server/ftp.php");

HTM::cap("file = $fil", "small");

$ini = new iniMgr("LOC_CFG/ftp.ini");
$ini->update($fil);
$ini->show();

// ***********************************************************
HTM::tag("ftp.check");
// ***********************************************************
$ftp = new ftp();
$chk = $ftp->test();

?>
