<?php
# used for directories with multiple numbered html files

$loc = PFS::getLoc();
$arr = APP::files("$loc/*.htm");
$cnt = 1;

if (count($arr) < 1) {
	return MSG::now("no.files");
}

foreach ($arr as $dir => $nam) {
	$arr[$dir] = "Kapitel ".$cnt++;
}

// ***********************************************************
incCls("menus/dropnav.php");
// ***********************************************************
$box = new dropnav();
$dir = $box->getKey("chap", $arr);
$xxx = $box->show();

// ***********************************************************
// show collected pages
// ***********************************************************
echo APP::gc($dir);

?>
