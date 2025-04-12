<?php
# a collection will collect all subdirectories of the current page
# (first level only) and display according to the given template

DBG::file(__FILE__);

if (! PFS::count()) {
	return MSG::now("no.subfolders");
}

// ***********************************************************
// read collected items (subdirs)
// ***********************************************************
$arr = PFS::items();
$lst = array();

foreach ($arr as $inf) {
	extract($inf);
	$lst[$fpath] = $title;
}

// ***********************************************************
incCls("menus/dropNav.php");
// ***********************************************************
$box = new dropNav();
$dir = $box->getKey("coll", $lst, $sel);
$tit = $box->decode("coll", $dir);
$xxx = $box->show();

$xxx = APP::addPath($dir);
$htm = APP::gcSys($dir);
$pic = PFS::pic($dir);

// ***********************************************************
// show collected pages
// ***********************************************************
$tpl = new tpl();
$tpl->load("pages/collect.tpl");
$tpl->set("text", $htm);
$tpl->set("head", $tit);

#if (VMODE == "ebook") {
#	$tpl->substitute("pic", "thumb");
#}

switch ($pic) {
	case true: $tpl->set("pic", $pic); break;
	default:   $tpl->clearSec("pic");
}
$tpl->show();

?>
