<?php

$lst = SSV::myFiles();
ksort($lst);

// ***********************************************************
incCls("menus/dropMenu.php");
// ***********************************************************
$box = new dropMenu();
$idx = $box->getKey("idx", $lst);
$div = $box->getKey("div", STR::toArray(".dbg.prm.env.pfs.oid.tan."));
$xxx = $box->show();

$arr = VEC::get($_SESSION, $idx);
$arr = VEC::get($arr, $div);

if (! $arr) return HTW::xtag("no.match", "p");
ksort($arr);

// ***********************************************************
incCls("menus/tview.php");
// ***********************************************************
$tvw = new tview();
$tvw->setData($arr);
$tvw->show();

?>
