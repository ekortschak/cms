<?php

DBG::file(__FILE__);
HTW::xtag("tpc.info", "h3");

// ***********************************************************
incCls("menus/buttons.php");

$nav = new buttons("abstract", "A", __DIR__);
$nav->add("A", "doAbstract");
$nav->add("C", "doStats");
$nav->space();
$nav->add("V", "view");
$nav->show();

?>

