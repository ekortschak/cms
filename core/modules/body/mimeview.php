<?php

$loc = PFS::getLoc();

$ini = new ini();
$ext = $ini->get("props.ext", "pics");
$dir = $ini->get("props.path", $loc);

$arr = FSO::files("$dir/*");
$arr = FSO::filter($arr, $ext);

// ***********************************************************
incCls("menus/dropnav.php");
// ***********************************************************
$box = new dropnav();
$fil = $box->getKey("file", $arr);
$xxx = $box->show();

$fil = FSO::clearRoot($fil);

// ***********************************************************
// show file
// ***********************************************************
$tpl = new tpl();
$tpl->read("design/templates/modules/fview.mimetype.tpl");
$tpl->set("url", $fil);
$tpl->show();

?>
