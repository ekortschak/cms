<?php

DBG::file(__FILE__);

// ***********************************************************
$arr = PFS::items();

// ***********************************************************
// show horizontal menu
// ***********************************************************
incCls("menus/menu.php");

$nav = new menu();
$nav->setData($arr);
$nav->show();

?>
