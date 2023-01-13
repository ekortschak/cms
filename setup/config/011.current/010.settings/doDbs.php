<?php

$inc = FSO::join(__DIR__, "common.php");
$inc = APP::relPath($inc);
$fcs = "dbase";

include($inc);

// ***********************************************************
HTW::xtag("dbo.check objects");
// ***********************************************************
$sts = ENV::dbState();

if ($sts == "nodb")  return MSG::now("db.missing");
if ($sts == "nocon") return MSG::now("db.con");

?>
