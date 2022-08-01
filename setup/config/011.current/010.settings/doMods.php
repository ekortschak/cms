<?php

incCls("editor/iniMgr.php");

// ***********************************************************
// read and write data
// ***********************************************************
$fil = "config/mods.ini";

#HTM::tag("mod.vars");
HTM::cap($fil);

$ini = new iniMgr("design/config/mods.ini");
$ini->read($fil);
$ini->save($fil);
$ini->show();

?>
