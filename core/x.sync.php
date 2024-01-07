<?php

include_once "config/fallback.php";

include_once "include/fallback.php";
include_once "include/load.err.php";
include_once "include/load.min.php";
include_once "include/defaults.php";

incCls("server/xfer.php");

// ***********************************************************
// return requested data
// ***********************************************************
$srv = new xfer();
$srv->act();

?>

<hr>
FX DONE
