<?php

$inc = FSO::join(__DIR__, "common.php");
$fcs = "dbase";

include($inc);

// ***********************************************************
HTM::tag("dbo.check objects");
// ***********************************************************
$con = "-"; if (DB_CON) $con = "OK";

MSG::now("db.con", $con);

?>
