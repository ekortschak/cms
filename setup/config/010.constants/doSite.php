<?php

incCls("editor/iniMgr.php");

// ***********************************************************
// read and write data
// ***********************************************************
$fil = "config/config.ini";

$ini = new iniMgr("design/config/config.ini");
$ini->read($fil);
$ini->save($fil);
$ini->show();

?>
