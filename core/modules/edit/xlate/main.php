<?php

DBG::file(__FILE__);

// ***********************************************************
// check if applicable
// ***********************************************************
if (! FS_ADMIN) {
	return APP::mod("msgs/stop");
}

// ***********************************************************
incCls("menus/buttons.php");
// ***********************************************************
$nav = new buttons("xlate", "X", __DIR__);
$nav->add("X", "doXLate");
$nav->space();
$nav->add("F", "doXRef");
$nav->show();

?>
