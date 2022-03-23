<?php

$arr = PFS::getMenu();

// ***********************************************************
// show horizontal menu
// ***********************************************************
incCls("menus/menu.php");

$nav = new menu();
$nav->setData($arr);
$nav->show();

?>
