<?php

$lev = ENV::get("maxDepth", 99);
$arr = PFS::getMenu($lev);

// ***********************************************************
// show horizontal menu
// ***********************************************************
incCls("menus/menu.php");

$nav = new menu();
$nav->setData($arr);
$nav->show();

?>
