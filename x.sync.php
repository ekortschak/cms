<?php

ob_start();

include_once("config/basics.php");
include_once("core/inc.min.php");

incCls("/server/fileServer.php");

echo ob_get_clean();

// ***********************************************************
$srv = new srvX();
$srv->act();

?>

<hr>
<p>CMS: FX complete</p>
