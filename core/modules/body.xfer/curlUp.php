<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ***********************************************************
include_once "core/classes/server/curl.php";

// ***********************************************************
$snc = new curl();
$snc->copy("index.php");

?>
xxx
