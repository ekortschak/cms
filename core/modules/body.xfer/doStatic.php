<?php

incCls("input/confirm.php");
incCls("input/qikOption.php");
incCls("editor/xform.php");

// ***********************************************************
$xfm = new xform(3);
$dir = $xfm->getDir();
$idx = $xfm->isPage();

if ($idx) {
	$url = APP::relPath($idx);
	$msg = DIC::get("static.show");

	$lnk = HTM::href($url, $msg, "static");
	echo "<hr>$lnk<hr>";
}
else {
	$msg = DIC::get("static.none");
	echo "<hr>$msg<hr>";
}

// ***********************************************************
// options
// ***********************************************************
$qik = new qikOption();
$dbg = $qik->getVal("opt.debug", 1);
$prv = $qik->gc();

$dst = $xfm->getDir();

// ***********************************************************
// ask for confirmation
// ***********************************************************
$msg = DIC::get("static.create");

$cnf = new confirm();
$cnf->head($msg);
$cnf->dic("from", PGE::$dir);
$cnf->add("&rarr; $dst");
$cnf->add("<hr>");
$cnf->add($prv);
$cnf->show();

if (!$cnf->act()) return;

// ***********************************************************
// create static files
// ***********************************************************
$arr = PFS::getData("dat");

$xfm->pages($arr);
$xfm->report();

?>
