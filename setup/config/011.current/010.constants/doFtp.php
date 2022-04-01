<?php

incCls("editor/iniMgr.php");

// ***********************************************************
// read and write data
// ***********************************************************
$fil = "config/ftp.ini";

$ini = new iniMgr("design/config/ftp.ini");
$ini->read($fil);
$ini->save($fil);
$ini->show();

// ***********************************************************
HTM::tag("ftp.check");
// ***********************************************************
incCls("server/ftp.php");

$ftp = new ftp();
$chk = $ftp->test();

?>
