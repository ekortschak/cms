<?php

DBG::file(__FILE__);

// ***********************************************************
// select records
// ***********************************************************
incCls("search/sView.php");

$vew = new sView();
$act = $vew->showNav();

if (! $act) {
	$vew->show("none");
	return;
}

$fls = $vew->getSnips();
$mod = $vew->getMode();

// ***********************************************************
// preview searched item
// ***********************************************************
$fil = APP::incFile(__DIR__, "do_$mod.php");

include_once($fil);

?>
