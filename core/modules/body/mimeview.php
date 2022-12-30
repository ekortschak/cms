<?php

$loc = PFS::getLoc();

$ini = new ini();
$ext = $ini->get("props.ext", "pics");
$dir = $ini->get("props.path", $loc);

$arr = FSO::files("$dir/*");
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
