<?php

incCls("menus/dropBox.php");
incCls("input/selector.php");
incCls("editor/tidy.php");

HTW::xtag("code.tidy");

// ***********************************************************
// get parameters
// ***********************************************************
$sel = new selector();
$oid = $sel->register("search.xxx");
$dir = $sel->ronly("dir", CUR_PAGE);
$act = $sel->show();

$lng = CUR_LANG;
$arr = FSO::ftree($dir, "*.$lng.*");

// ***********************************************************
// find & sweep files
// ***********************************************************
$tdy = new tidy();

foreach ($arr as $ful => $nam) {
	$htm = APP::read($ful);
	APP::write($ful, $tdy->get($htm));
}

?>
Done
