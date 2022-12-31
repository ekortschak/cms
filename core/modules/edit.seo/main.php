<?php

if (! FS_ADMIN) {
	incMod("stop.php");
	return;
}

incCls("menus/buttons.php");

// ***********************************************************
// show options
// ***********************************************************
$loc = PFS::getLoc();
$dir = FSO::mySep(__DIR__);

HTW::xtag("seo", "h3");

// ***********************************************************
// show options
// ***********************************************************
$nav = new buttons("seo", "L", $dir);

$nav->add("L", "doLinks");
$nav->add("K", "doMetaKeys");
$nav->add("D", "doMetaDesc");
$nav->show();

$nav->showContent();

?>
