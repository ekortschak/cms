<?php

incCls("menus/dropBox.php");
incCls("input/selector.php");
incCls("editor/tidyPage.php");

HTW::xtag("code.tidy");

// ***********************************************************
// get parameters
// ***********************************************************
$sel = new selector();
$oid = $sel->register("search.xxx");
$dir = $sel->ronly("dir", PGE::$dir);
$act = $sel->show();

$lng = CUR_LANG;
$arr = FSO::fTree($dir, "*.$lng.*");

// ***********************************************************
// find & sweep files
// ***********************************************************
$tdy = new tidyPage();

foreach ($arr as $ful => $nam) {
	$htm = $tdy->read($ful);
	$htm = $tdy->restore($htm);

	APP::write($ful, $htm);
}

?>
Done
