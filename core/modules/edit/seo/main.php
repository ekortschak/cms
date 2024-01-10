<?php

if (! FS_ADMIN) {
	incMod("msgs/stop.php");
	return;
}

DBG::file(__FILE__);

// ***********************************************************
incCls("menus/buttons.php");
// ***********************************************************
$nav = new buttons("seo", "L", __DIR__);
$nav->add("L", "doLinks");
$nav->add("K", "doMetaKeys");
$nav->add("D", "doMetaDesc");
$nav->show();

?>
