<?php

incCls("input/confirm.php");
incCls("editor/xform.php");

$xfm = new xform(3);
$dir = $xfm->getDir();
$idx = $xfm->isPage();

if ($idx) {
	$url = APP::relPath($idx);
	$msg = DIC::get("static.show");
	echo "<hr><a href='$url' target='static'>$msg</a><hr>";
}
else {
	$msg = DIC::get("static.none");
	echo "<hr>$msg<hr>";
}

// ***********************************************************
// set data
// ***********************************************************
$dir = PFS::getLoc();
$arr = PFS::getData("dat");

// ***********************************************************
// options
// ***********************************************************
incCls("menus/qikLink.php");

$qik = new qikLink();
$dbg = $qik->getVal("opt.debug", 1);
$prv = $qik->gc();

$dst = $xfm->getDir();

// ***********************************************************
// ask for confirmation
// ***********************************************************
$msg = DIC::get("static.create");

$cnf = new confirm();
$cnf->head($msg);
$cnf->dic("from", $dir);
$cnf->add("&rarr; $dst");
$cnf->add("<hr>");
$cnf->add($prv);
$cnf->show();

if (!$cnf->act()) return;

// ***********************************************************
// create static files
// ***********************************************************
$xfm->pages($arr);
$xfm->report();

?>
