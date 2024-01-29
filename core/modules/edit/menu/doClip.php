<?php

if (PFS::isStatic()) {
	return MSG::now("mnu.static");
}

// ***********************************************************
// modifications handled by edit.menu/saveMenu.php
// ***********************************************************
$dir = LOC::tempDir("clipboard");
$arr = FSO::dirs($dir);

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
$tpl->set("curloc", PGE::$dir);
$tpl->set("curuid", uniqid());
$tpl->set("box", $obj);
$tpl->show();

?>
