<?php

incCls("menus/buttons.php");

// ***********************************************************
ENV::set("lookup", false);
// ***********************************************************
$nav = new buttons("lup", "E", __DIR__);

$nav->add("A", "doAdd",  "add");
$nav->add("E", "doEdit", "edit");
$nav->add("D", "doDrop", "drop");
$nav->add("I", "doInject");
$nav->show();

?>
