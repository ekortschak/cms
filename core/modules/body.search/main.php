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
include APP::getInc(__DIR__, "do_$mod.php");

?>
