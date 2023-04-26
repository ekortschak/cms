<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

error_reporting(E_ALL);

define("ERR_SHOW", 1);

// ***********************************************************
include_once "config/fallback.php";
include_once "core/include/load.min.php";
include_once "core/include/load.more.php";

// ***********************************************************
if (! IS_LOCAL) die("Thanks for stopping by ...");

// ***********************************************************
incFnc("pagemaker.php");

?>
<hr>
Still alive ...
