<?php

incCls("menus/dropBox.php");
incCls("input/selector.php");

// ***********************************************************
// show file selector
// ***********************************************************
$fnt = APP::files("design/fonts", "*.ttf");

$box = new dropBox("menu");
$fnt = $box->getKey("Font", $fnt);
$xxx = $box->show();

ENV::set("Font", $fnt);

// ***********************************************************
// find tabsets
// ***********************************************************
$ini = new iniTab(TAB_ROOT);
$tit = $ini->title();

HTW::tag("Tab = $tit");

// ***********************************************************
// create vtab pics
// ***********************************************************
$fil = APP::snip(TAB_ROOT, "tab", "png");
$fil = APP::relPath($fil);

$sec = "add.png"; if ($fil) $sec = "del.png";

$tpl = new tpl();
$tpl->load("editor/menu.tab.tpl");
$tpl->register();
$tpl->set("file", $fil);
$tpl->show("png.info");
$tpl->show($sec);

?>

