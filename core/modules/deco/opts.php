<?php

$fbk = (APP::isView() && (DB_CON != "none"));

incCls("menus/qikLink.php");

// ***********************************************************
HTM::tag("Options");
// ***********************************************************
$qik = new qikLink(); if ($fbk)
$qik->getVal("opt.feedback", 0);
$qik->getVal("opt.tooltip", 0);
$qik->show();

?>
