<?php
# a collection will collect all subdirectories of the current page
# (first level only) and display according to the given template

DBG::file(__FILE__);

// ***********************************************************
$loc = PGE::dir();
$sel = ENV::getParm("coll");
$arr = APP::folders($loc);
$lst = array();

if (count($arr) < 1) {
	return MSG::now("no.subfolders");
}

// ***********************************************************
// read subdirs
// ***********************************************************
foreach ($arr as $dir => $itm) {
	$ini = new ini($dir);
	$lst[$dir] = $ini->getHead();
}

// ***********************************************************
incCls("menus/dropNav.php");
// ***********************************************************
$box = new dropNav();
$dir = $box->getKey("coll", $lst, $sel);
$tit = $box->decode("coll", $dir);
$xxx = $box->show();

$whr = FSO::join(APP_DIR, $dir);
$xxx = APP::addPath($whr);

$htm = APP::gcSys($dir);
$pic = PGE::pic($dir);

// ***********************************************************
// show collected pages
// ***********************************************************
$tpl = new tpl();
$tpl->load("pages/collect.tpl");

$tpl->set("text", $htm);
$tpl->set("head", $tit);
$tpl->set("pic", $pic);

if (! $pic) {
	$tpl->clearSec("pic");
}
$tpl->show();

?>
