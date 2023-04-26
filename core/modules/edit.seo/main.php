<?php

if (! FS_ADMIN) {
	incMod("stop.php");
	return;
}

HTW::xtag("seo", "h3");

incCls("menus/buttons.php");

// ***********************************************************
$nav = new buttons("seo", "L", __DIR__);
// ***********************************************************
$nav->add("L", "doLinks");
$nav->add("K", "doMetaKeys");
$nav->add("D", "doMetaDesc");
$nav->show();

?>
