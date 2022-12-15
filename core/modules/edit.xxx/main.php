<?php

incCls("menus/buttons.php");
$dir = FSO::mySep(__DIR__);

// ***********************************************************
HTM::tag("xedit", "h3");
// ***********************************************************
$nav = new buttons("xedit", "S", $dir);

$nav->add("S", "doSearch");
$nav->add("R", "doRename");

$nav->add("N", "doNums");
$nav->add("T", "doTidy");

$nav->addSpace(5);

$nav->add("X", "doXLate");
$nav->add("F", "doXRef");

$nav->show();

// ***********************************************************
// show content
// ***********************************************************
$nav->showContent();

?>
