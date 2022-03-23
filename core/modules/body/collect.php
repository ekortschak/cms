<?php
# a collection will collect all subdirectories of the current page
# (first # level only) and display according to the given template

$loc = PFS::getLoc();
$arr = APP::folders($loc);
$lst = array();

if (count($arr) < 1) {
	return MSG::now("no.subfolders");
}

// ***********************************************************
// read subdirs
// ***********************************************************
foreach ($arr as $dir => $itm) {
	$ini = new ini();
	$ini->read($dir);

	$lst[$dir] = $ini->getHead();
}

// ***********************************************************
incCls("menus/dropnav.php");
// ***********************************************************
$box = new dropnav();
$box->setSpaces(0, 0);
$dir = $box->getKey("coll", $lst);
$tit = $box->decode("coll", $dir);
$xxx = $box->show();

$pic = APP::files($dir, "png,jpg,gif");
$pic = basename(key($pic));
$dir = FSO::clearRoot($dir);
$pic = FSO::join($dir, $pic);

// ***********************************************************
// show collected pages
// ***********************************************************
$tpl = new tpl();
$tpl->read("design/templates/modules/collect.tpl");

if (! is_file($pic)) {
	$tpl->setSec("pic", "");
}
$tpl->set("head", $tit);
$tpl->set("pic", $pic);
$tpl->set("text", APP::gc($dir));
$tpl->show();

?>
