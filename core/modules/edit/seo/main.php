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
$nav = new buttons("seo", "L", __DIR__);
$nav->add("L", "doLinks");
$nav->add("K", "doMetaKeys");
$nav->add("D", "doMetaDesc");
$nav->show();

?>
