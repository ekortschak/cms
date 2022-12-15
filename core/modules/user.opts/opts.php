<?php

incCls("menus/qikLink.php");

// ***********************************************************
HTM::tag("options");
// ***********************************************************
$few = false;

if ($cfg->get("uopts.fback")) {
	$few = APP::isView(); if ($few) // feedback
	$few = STR::contains(DB_MODE, "sql");
}

$qik = new qikLink(); if ($few)
$qik->getVal("opt.feedback", 0);
$qik->getVal("opt.tooltip", 0);
$qik->show();

?>
