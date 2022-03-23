<?php

$dir = FSO::mySep(__DIR__);
$tpl = basename($fil);

// ***********************************************************
// show buttons
// ***********************************************************
incCls("editor/iniMgr.php");

$ini = new iniMgr("design/config/$tpl");
$ini->read($fil);
$ini->save($fil);
$ini->show();

?>
