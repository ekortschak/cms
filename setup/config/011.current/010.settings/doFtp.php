<?php

incCls("editor/iniMgr.php");

// ***********************************************************
// read and write data
// ***********************************************************
$fil = "config/ftp.ini";
incCls("server/ftp.php");

HTM::cap($fil);

$ini = new iniMgr("design/config/ftp.ini");
$ini->update($fil);
$ini->show();

// ***********************************************************
HTM::tag("ftp.check");
// ***********************************************************
$ftp = new ftp();
$chk = $ftp->test();

?>