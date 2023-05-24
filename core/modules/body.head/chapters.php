<?php
# used for directories with multiple numbered html files

$arr = APP::files(PGE::$dir, "*.htm");
$cnt = 1;

if (count($arr) < 1) {
	return MSG::now("no.files");
}

foreach ($arr as $dir => $nam) {
	$arr[$dir] = "Kapitel ".$cnt++;
}

// ***********************************************************
incCls("menus/dropNav.php");
// ***********************************************************
$box = new dropNav();
$dir = $box->getKey("chap", $arr);
$xxx = $box->show();

// ***********************************************************
// show collected pages
// ***********************************************************
echo APP::gcFile($dir);

?>
