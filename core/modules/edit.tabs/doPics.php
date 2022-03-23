<?php

incCls("menus/tabset.php");
incCls("menus/dropbox.php");
incCls("input/selector.php");

// ***********************************************************
// collect info
// ***********************************************************
$fnt = APP::files("design/fonts/*.ttf");

$tbs = new tabset();
$arr = $tbs->validSets();

// ***********************************************************
// show file selector
// ***********************************************************
$box = new dbox();
$set = $box->getKey("TabSet", $arr, APP_CALL);
$lst = $tbs->getTabs($set, true);
$tab = $box->getKey("Tab", $lst, TOP_PATH);
$xxx = $box->show("menu");

$fnt = $box->getKey("Font", $fnt);
$xxx = $box->show("table");

ENV::set("Font", $fnt);

// ***********************************************************
// create vtab pics
// ***********************************************************
$tpl = new tpl();
$tpl->read("design/templates/editor/mnuTab.tpl");
$tpl->set("tab", TAB_ROOT);
$tpl->show("add.png");
$tpl->show("del.png");

// ***********************************************************
// show pic
// ***********************************************************
$fil = APP::find(TAB_ROOT, "tab", "png");
$sec = "show.png"; if (! $fil) $sec.= ".none";

$tpl->set("file", $fil);
$tpl->show($sec);

?>

