<?php

$fsz = "1.75rem"; if (isset($_GET["fsize"]))
$fsz = $_GET["fsize"];

define("LAYOUT", "pres");
define("SSHEET", "pres");
define("FSIZE", $fsz);

include_once "core/index.php";

?>


