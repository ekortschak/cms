<?php

session_start();

require_once "include/fallback.php";
require_once "include/funcs.php";

// ***********************************************************
// get context
// ***********************************************************
$tbs = appVar("tabset", "default");
$mod = appVar("vmode", "view");

if ($tbs !== "config") $tbs = "default";

define("TAB_SET", $tbs); if (! defined("CSS_URL"))
define("CSS_URL", "x.css.php");

// ***********************************************************
// determine include file
// ***********************************************************
switch ($mod) {
	case "pedit": case "medit": case "xedit": case "tedit":
	case "xlate": case "xfer":  case "seo":
		$inc = "x.edit"; break;

	default: $inc = appMode($mod);
}

// ***********************************************************
// act according to vmode
// ***********************************************************
appInclude("core/$inc.php");

?>
