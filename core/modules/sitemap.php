<?php

DBG::file(__FILE__);

if (VMODE == "ebook") return;

// ***********************************************************
// show default sitemap message
// ***********************************************************
if (! PFS::count()) {
	$tpl = new tpl();
	$tpl->load("msgs/sitemap.tpl");
	return $tpl->show("notyet");
}

// ***********************************************************
// offer subdirectories for further navigation
// ***********************************************************
incCls("menus/toc.php");

$toc = new toc();
$toc->set("pfx", "smap");
$toc->show();

?>
