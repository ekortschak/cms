<?php

incCls("input/confirm.php");
incCls("editor/xform.php");

$xfm = new xform(3);
$dir = $xfm->getDir();
$idx = $xfm->isPage();

if ($idx) {
	$url = FSO::clearRoot($idx);
	echo "<hr><a href='$url' target='static'>Show existing static file(s)</a><hr>";
}
else {
	echo "<hr>No static files existing yet<hr>";
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

$frm = DIC::get("from");
$dst = $xfm->getDir();

// ***********************************************************
// ask for confirmation
// ***********************************************************
$cnf = new confirm();
$cnf->head("Create static files");
$cnf->add("$frm $dir");
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
