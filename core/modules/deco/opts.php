<?php

$fbk = (APP::isView() && DB_CON);

incCls("menus/qikLink.php");

// ***********************************************************
HTM::tag("Options");
// ***********************************************************
$qik = new qikLink(); if ($fbk)
$qik->getVal("opt.feedback");
$qik->getVal("opt.tooltip", 0);
$qik->show();

?>
