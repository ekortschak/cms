<?php

incCls("search/searchView.php");

// ***********************************************************
// select records
// ***********************************************************
$vew = new searchView();
$xxx = $vew->showNav();
$fls = $vew->getSnips($dir);
$mod = $vew->getMode();

if (! $fls) {
	$vew->show("none");
	return;
}

// ***********************************************************
// preview searched item
// ***********************************************************
$inc = FSO::join(__DIR__, "do_$mod.php");
$inc = APP::relPath($inc);

include $inc;

?>
