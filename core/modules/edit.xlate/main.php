<?php

if (! FS_ADMIN) {
	incMod("msgs/stop.php");
	return;
}

HTW::xtag("xlRef.title", "h3");
DBG::file(__FILE__);

// ***********************************************************
incCls("menus/buttons.php");
// ***********************************************************
$nav = new buttons("xlate", "X", __DIR__);
$nav->add("X", "doXLate");
$nav->space();
$nav->add("F", "doXRef");
$nav->show();

?>
