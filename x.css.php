<?php

session_start();

if (isset($_GET["layout"])) define("LAYOUT", $_GET["layout"]);

// ***********************************************************
// read css
// ***********************************************************
include_once("config/basics.php");
include_once("core/inc.css.php");

$css = new css();
$css->get();

?>
