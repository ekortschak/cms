<?php
# a collection will collect all subdirectories of the current page
# (first # level only) and display according to the given template

$arr = APP::folders(CUR_PAGE);
$sel = ENV::getParm("coll");
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

$pic = APP::files($dir, "*.png, *.jpb, *.gif");
$pic = basename(key($pic));
$dir = APP::relPath($dir);
$pic = FSO::join($dir, $pic);

// ***********************************************************
// show collected pages
// ***********************************************************
$tpl = new tpl();
$tpl->load("modules/collect.tpl");

if (! is_file($pic)) {
	$tpl->clearSec("pic");
}
$tpl->set("head", $tit);
$tpl->set("pic", $pic);
$tpl->set("text", APP::gc($dir));
$tpl->show();

?>
