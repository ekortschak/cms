<?php


$show = false; if (IS_LOCAL)
$show = ERR_SHOW;

// ***********************************************************
// error handling
// ***********************************************************
$err = E_CORE_ERROR; if ($show)
$err = E_ALL;

error_reporting($err);
register_shutdown_function("shutDown");
set_error_handler("errHandler");

// ***********************************************************
// define error options
// ***********************************************************
ini_set("ignore_repeated_errors", 1);
ini_set("display_startup_errors", $show);
ini_set("display_errors", $show);

ini_set("error_log", LOG::file("error.log"));

// ***********************************************************
// define selected syntax colors
// ***********************************************************
ini_set("highlight.comment", "red");
ini_set("highlight.default", "navy");
ini_set("highlight.html", "purple");
ini_set("highlight.keyword", "green");
ini_set("highlight.string", "orange");

?>
