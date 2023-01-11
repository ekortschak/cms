<?php

$dir = FSO::mySep(__DIR__);

// ***********************************************************
incCls("menus/buttons.php");
// ***********************************************************
$nav = new buttons("dbs", "H", $dir);
$nav->add("H", "doRescue");
$nav->show();

$nav->showContent();

?>

