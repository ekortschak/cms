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

if (! FS_ADMIN) CFG::set("VMODE","login");

// ***********************************************************
// supply defaults
// ***********************************************************
include_once "include/load.std.php";

// ***********************************************************
// create page
// ***********************************************************
incFnc("pagemaker.php");

?>
