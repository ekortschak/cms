<?php

include_once "config/fallback.php";
include_once "include/load.min.php";

// ***********************************************************
// determine method
// ***********************************************************
$fnc = "xfer"; if ($_FILES)
$fnc = "curl";

incCls("server/$fnc.php");

// ***********************************************************
// return requested data
// ***********************************************************
$srv = new $fnc();
$srv->act();

?>

<hr>
FX DONE
