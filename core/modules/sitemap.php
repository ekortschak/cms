<?php

DBG::file(__FILE__);

// ***********************************************************
$loc = PGE::$dir;
$arr = PFS::sibs($loc);

// ***********************************************************
// show default sitemap message
// ***********************************************************
if (! $arr) {
	$tpl = new tpl();
	$tpl->load("msgs/sitemap.tpl");
	return $tpl->show("notyet");
}

// ***********************************************************
// offer subdirectories for further navigation
// ***********************************************************
incCls("menus/toc.php");

$toc = new toc();
$toc->setData($arr);
$toc->set("pfx", "smap");
$toc->show();

?>
