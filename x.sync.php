<?php

include_once "config/fallback.php";
include_once "core/inc.min.php";

incCls("server/fileServer.php");

// ***********************************************************
error_reporting(E_ALL);

// ***********************************************************
$srv = new fileServer();
$srv->act();

?>

<hr>
FX DONE
