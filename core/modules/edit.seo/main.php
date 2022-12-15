<?php

incCls("menus/buttons.php");
$dir = FSO::mySep(__DIR__);

// ***********************************************************
HTM::tag("seo", "h3");
// ***********************************************************
$nav = new buttons("seo", "L", $dir);

$nav->add("L", "doLinks");
$nav->add("K", "doMetaKeys");
$nav->add("D", "doMetaDesc");

$nav->show();

// ***********************************************************
// show content
// ***********************************************************
$nav->showContent();

?>
