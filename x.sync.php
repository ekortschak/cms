<?php

include_once "config/fallback.php";
include_once "core/inc.min.php";

// ***********************************************************
// determine method
// ***********************************************************
$fnc = "xfer"; if ($_FILES) 
$fnc = "curl";

// ***********************************************************
incCls("server/$fnc.php");

$srv = new $fnc();
$srv->act();

?>

<hr>
FX DONE
