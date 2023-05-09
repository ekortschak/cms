<?php

incCls("search/sView.php");

// ***********************************************************
// select records
// ***********************************************************
$vew = new sView();
$xxx = $vew->showNav();
$fls = $vew->getSnips();
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
