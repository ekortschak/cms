<?php

$tpl = basename($fil);

// ***********************************************************
// show buttons
// ***********************************************************
incCls("editor/iniMgr.php");

$ini = new iniMgr("LOC_CFG/$tpl");
$ini->update($fil);
$ini->show();

?>
