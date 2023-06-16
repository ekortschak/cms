<?php

$inc = APP::getInc(__DIR__, "common.php");
$fcs = "dbase";

include $inc;

// ***********************************************************
HTW::xtag("dbo.check objects");
// ***********************************************************
$sts = CFG::dbState();

if ($sts == "nodb")  return MSG::now("db.missing");
if ($sts == "nocon") return MSG::now("db.con");

MSG::now("db.con ok");

?>
