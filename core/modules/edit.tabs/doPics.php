<?php

incCls("menus/localMenu.php");
incCls("input/selector.php");

// ***********************************************************
// show file selector
// ***********************************************************
$fnt = APP::files("design/fonts/*.ttf");

$box = new localMenu();
$fnt = $box->getKey("Font", $fnt);
$xxx = $box->show();

ENV::set("Font", $fnt);

// ***********************************************************
// find tabsets
// ***********************************************************
$ini = new iniTab(TAB_ROOT);
$tit = $ini->getTitle();

HTW::tag("Tab = $tit");

// ***********************************************************
// create vtab pics
// ***********************************************************
$fil = APP::find(TAB_ROOT, "tab", "png");
$sec = "add.png"; if ($fil) $sec = "del.png";

$tpl = new tpl();
$tpl->load("editor/menu.tab.tpl");
$tpl->set("tab", TAB_ROOT);
$tpl->set("file", APP::relPath($fil));
$tpl->show($sec);

?>

