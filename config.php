<?php

define("LAYOUT", "edit");

include_once("config/basics.php");
include_once("core/inc.min.php");
include_once("core/inc.more.php");

if (! FS_ADMIN) {
	$_GET["dmode"] = "login";
}

incFnc("pagemaker.php");

?>
