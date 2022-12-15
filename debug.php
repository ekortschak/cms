<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(0);

// ***********************************************************
include_once("config/basics.php");
include_once("core/inc.min.php");
include_once("core/inc.more.php");

// ***********************************************************
echo "<pre>";
CFG::dump("users");
echo "</pre>";

?>
<hr>
Success !
<hr>
