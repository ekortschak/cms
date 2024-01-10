<?php

return;

incCls("menus/dropBox.php");

// ***********************************************************
$arr = CFG::iniGroup("bookmarks:day1"); #if (! $arr) return;
$arr = VEC::flip($arr);

// ***********************************************************
HTW::xtag("bookmarks");
// ***********************************************************
$box = new dropBox("button");
$box->hideDesc();
$box->getKey("goto", $arr);
$box->show();

?>
