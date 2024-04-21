<?php

incCls("input/confirm.php");
incCls("editor/statfs.php");

// ***********************************************************
$xfm = new statfs(3);
$dst = $xfm->getDir();
$xxx = $xfm->status();

// ***********************************************************
// ask for confirmation
// ***********************************************************
$msg = DIC::get("static.create");

$cnf = new confirm();
$cnf->dic("from", PGE::$dir);
$cnf->add("&rarr; $dst");
$cnf->show();

if (! $cnf->act()) return;

// ***********************************************************
// create static files
// ***********************************************************
$arr = PFS::data("dat");

$xfm->pages($arr);
$xfm->report();

?>
