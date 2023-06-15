<?php

# if (! defined("LAYOUT")) define("LAYOUT", "default");
# if (! defined("VMODE"))  define("VMODE",  "pedit");

// ***********************************************************
// load essential modules
// ***********************************************************
include_once "config/fallback.php";

include_once "include/load.err.php";
include_once "include/load.min.php";
include_once "include/load.more.php";

// ***********************************************************
// require login
// ***********************************************************
requireAdmin();

// ***********************************************************
// create page
// ***********************************************************
incFnc("pagemaker.php");

?>
