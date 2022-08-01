<?php

ob_start();

include_once("config/basics.php");
include_once("core/inc.min.php");
include_once("core/classes/server/fileServer.php");

echo ob_get_clean();

// ***********************************************************
#ini_set('display_errors', 1);
#error_reporting(E_ALL);

// ***********************************************************
$srv = new srvX();
$srv->act();

?>

<hr>
<p>CMS: FX complete</p>
