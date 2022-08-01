<?php

incCls("menus/buttons.php");
$dir = FSO::mySep(__DIR__);

// ***********************************************************
HTM::cap("Extended Editing", "h3");
// ***********************************************************
$nav = new buttons("xedit", "S", $dir);

$nav->add("S", "doSearch");
$nav->add("Y", "doTidy");
$nav->add("N", "doNums");
$nav->add("L", "doLinks");
$nav->add("T", "doTags");
$nav->add("M", "doKeywords");

$nav->show();

// ***********************************************************
// show content
// ***********************************************************
$nav->showContent();

?>
