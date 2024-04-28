<?php

DBG::file(__FILE__);

// ***********************************************************
// show horizontal menu
// ***********************************************************
incCls("menus/menu.php");

$nav = new menu();
$nav->show();

?>
