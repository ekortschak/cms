<?php

session_start();

require_once "include/fallback.php";
require_once "include/funcs.php";
require_once "include/SYS.php";

// ***********************************************************
// define context
// ***********************************************************
$tbs = SYS::get("tabset", "default");
$mod = SYS::get("vmode", "view");
$dbg = SYS::get("debug");

if ($tbs !== "config") $tbs = "default";

define("TAB_SET", $tbs);
define("DEBUG", $dbg);

// ***********************************************************
// determine include file
// ***********************************************************
$fil = SYS::startFile($mod);
include_once $fil;

?>
