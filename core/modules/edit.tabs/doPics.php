<?php

incCls("menus/localMenu.php");
incCls("input/selector.php");

$set = APP_CALL;

// ***********************************************************
// collect info
// ***********************************************************
$fnt = APP::files("design/fonts/*.ttf");

// ***********************************************************
// show file selector
// ***********************************************************
$box = new localMenu();
$fnt = $box->getKey("Font", $fnt);
$xxx = $box->show();

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

$tpl->set("file", APP::relPath($fil));
$tpl->show($sec);

?>

