<?php

if (PFS::isStatic()) {
	return MSG::now("mnu.static");
}

// ***********************************************************
incCls("editor/clipBoard.php");

$clp = new clipBoard();
$arr = $clp->getList();

// ***********************************************************
// show elements in clipboard
// ***********************************************************
incCls("input/combo.php");

$cmb = new combo("clip");
$cmb->setData($arr);
$obj = $cmb->gc();

$tpl = new tpl();
$tpl->load("editor/menu.clip.tpl");
$tpl->set("curloc", CUR_PAGE);
$tpl->set("box", $obj);
$tpl->show();

?>
