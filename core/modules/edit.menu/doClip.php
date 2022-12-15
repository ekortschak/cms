<?php

if (PFS::isStatic()) {
	return MSG::now("mnu.static");
}

$loc = PFS::getLoc();

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
$tpl->read("design/templates/editor/mnuClip.tpl");
$tpl->set("curloc", $loc);
$tpl->set("box", $obj);
$tpl->show();

?>
