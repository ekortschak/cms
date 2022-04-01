<?php

incCls("editor/iniMgr.php");

// ***********************************************************
// read and write data
// ***********************************************************
$fil = "config/dbase.ini";

$ini = new iniMgr("design/config/dbase.ini");
$ini->read($fil);
$ini->save($fil);
$ini->show();

// ***********************************************************
// visual feedback
// ***********************************************************
$con = ""; if (DB_CON) $con = "OK";

HTM::tag("dbo.check objects");
MSG::now("db.con", $con);

?>
