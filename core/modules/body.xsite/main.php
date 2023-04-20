<?php

// script is used to generate a single html from the folder structure
// which can then be saved as a pdf by the browser functionality.

$dbg = ENV::get("xsite.dbg", 0);

$cnt = 0; if ($dbg) $cnt = 3;

// ***********************************************************
// collect sub tree
// ***********************************************************
$arr = array(CUR_PAGE => "start");
$arr+= FSO::dtree(CUR_PAGE);

// ***********************************************************
// paste collected pages into single page
// ***********************************************************
incCls("editor/xsite.php");

$xfm = new xsite($cnt);
$xfm->read($arr);
$xfm->show();

?>
