<?php

include_once "config/fallback.php";
include_once "include/fallback.php";

require_once "include/funcs.php";
include_once "include/load.err.php";
include_once "include/load.min.php";

incCls("server/xfer.php");

// ***********************************************************
// return requested data
// ***********************************************************
$srv = new xfer();
$srv->act();

?>

<hr>
FX DONE
