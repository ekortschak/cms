<?php

incCls("menus/buttons.php");

// ***********************************************************
$nav = new buttons("ugrps", "A", __DIR__);
// ***********************************************************
$nav->add("A", "doAdd",  "add");
$nav->add("D", "doDrop", "drop");
$nav->show();

?>
