<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(0);

// ***********************************************************
// read css
// ***********************************************************
include_once("config/basics.php");
include_once("core/inc.css.php");

incCls("files/css.php");

$css = new css();
$css->get();

?>
