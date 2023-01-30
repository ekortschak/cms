<?php

$ext = PGE::get("props.ext", "pics");
$dir = PGE::get("props.path", CUR_PAGE);

$arr = FSO::files($dir);
$arr = FSO::filter($arr, $ext);
krsort($arr);

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
$tpl->load("modules/fview.mimetype.tpl");
$tpl->set("url", $fil);
$tpl->show();

?>
