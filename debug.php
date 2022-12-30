<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ***********************************************************
include_once("config/basics.php");
include_once("core/inc.min.php");
include_once("core/inc.more.php");

// ***********************************************************
incFnc("pagemaker.php");
return;


echo "<pre>";
CFG::dump("users");
echo "</pre>";

?>
<hr>
Success !
<hr>
