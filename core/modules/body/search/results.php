<?php

DBG::file(__FILE__);

incCls("search/sView.php");

// ***********************************************************
// select records
// ***********************************************************
$fnd = ENV::get("search.what", "");

$vew = new sView();
$act = $vew->showNav();

if (! $act) {
	$vew->show("none");
	return;
}

$mod = $vew->getMode();

// ***********************************************************
// preview searched item
// ***********************************************************
APP::inc(__DIR__, "do_$mod.php");

?>
