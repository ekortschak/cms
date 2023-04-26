<?php

$ext = PGE::get("props.ext", "pics");
$dir = PGE::get("props.path", CUR_PAGE);
$srt = PGE::get("props.sort");

$arr = FSO::files($dir);
$arr = FSO::filter($arr, $ext);

switch ($srt) {
	case "asc":  $arr = VEC::sort($arr, "ksort"); break;
	case "desc": $arr = VEC::sort($arr, "krsort");
}

// ***********************************************************
incCls("menus/dropNav.php");
// ***********************************************************
$box = new dropNav();
$fil = $box->getKey("file", $arr);
$xxx = $box->show();

$fil = APP::relPath($fil);

// ***********************************************************
// show file
// ***********************************************************
$tpl = new tpl();
#$tpl->load("modules/fview.mimetype.tpl");
$tpl->load("modules/fview.reorg.tpl");
$tpl->set("file", $fil);
$tpl->set("url",  $fil);
$tpl->show();

?>
