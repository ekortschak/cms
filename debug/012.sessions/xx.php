<?php

$lst = SSV::myFiles();

// ***********************************************************
incCls("menus/localMenu.php");
// ***********************************************************
$box = new localMenu();
$idx = $box->getKey("idx", $lst);
$div = $box->getKey("div", STR::toArray(".dbg.prm.env.pfs.oid.tan."));
$xxx = $box->show("compact");

$arr = VEC::get($_SESSION, $idx);
$arr = VEC::get($arr, $div);

if (! $arr) {
	echo NV;
	return;
}
ksort($arr);

// ***********************************************************
incCls("menus/tview.php");
// ***********************************************************
$tvw = new tview();
$tvw->setData($arr);
$tvw->show();

?>
