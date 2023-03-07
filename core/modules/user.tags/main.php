<?php

incCls("menus/dropBox.php");

// ***********************************************************
$arr = CFG::getVars("bookmarks", "day1"); #if (! $arr) return;
$arr = array_flip($arr);

// ***********************************************************
HTW::xtag("bookmarks");
// ***********************************************************
$box = new dropBox("button");
$box->hideDesc();
$box->getKey("goto", $arr);
$box->show();

?>
