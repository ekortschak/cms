<?php

if (PFS::isStatic()) {
	return MSG::now("mnu.static");
}

// ***********************************************************
$dir = APP::tempDir("clipboard");
$arr = FSO::folders($dir);

// ***********************************************************
// show elements in clipboard
// ***********************************************************
incCls("input/combo.php");

$cmb = new combo("clip.src");
$cmb->setData($arr);
$obj = $cmb->gc();

$tpl = new tpl();
$tpl->register();
$tpl->load("editor/menu.clip.tpl");
$tpl->set("curloc", CUR_PAGE);
$tpl->set("box", $obj);
$tpl->show();

?>
