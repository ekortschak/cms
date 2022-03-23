<?php

ob_start();

include_once("config/basics.php");
include_once("core/inc.min.php");
include_once("core/classes/server/fileServer.php");

echo ob_get_clean();

// ***********************************************************
$srv = new srvX();
$srv->act();

?>

<p>CMS: FX complete</p>
