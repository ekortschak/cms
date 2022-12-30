<?php

$dir = FSO::mySep(__DIR__);

// ***********************************************************
incCls("menus/buttons.php");
// ***********************************************************
$nav = new buttons("tbls", "P", $dir);
$nav->add("C", "doCopy");
$nav->add("A", "doAdd");
$nav->add("P", "doProps");
$nav->add("R", "doRen");
$nav->add("S", "doSort");
$nav->add("D", "doDrop");
$nav->add("U", "doPerms");
$nav->show();

$nav->showContent();

?>

