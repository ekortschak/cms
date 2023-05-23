<?php

// script is used to generate a single html from the folder structure
// which can then be saved as a pdf by the browser functionality.

$top = ENV::get("xsite.top", TAB_HOME);

// ***********************************************************
// paste collected pages into single page
// ***********************************************************
incCls("editor/xsite.php");

$xfm = new xsite();
$xfm->read($top);
$xfm->show();

?>
