<?php

incCls("menus/qikLink.php");

// ***********************************************************
HTW::xtag("options");
// ***********************************************************
$few = false;

if (VEC::get($cfg, "uopts.fback")) {
	$few = APP::isView(); if ($few) // feedback
	$few = STR::contains(DB_MODE, "sql");
}

$qik = new qikLink(); if ($few)
$qik->getVal("opt.feedback", 0);
$qik->getVal("opt.tooltip", 0);
$qik->show();

?>
