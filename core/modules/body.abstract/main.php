<?php

incCls("menus/buttons.php");

HTW::xtag("tpc.info", "h3");

// ***********************************************************
$nav = new buttons("abstract", "A", __DIR__);
// ***********************************************************
$nav->add("A", "doAbstract");
$nav->add("C", "doStats");
$nav->space();
$nav->add("V", "view");
$nav->show();

?>

