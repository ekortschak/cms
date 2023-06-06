<?php

incCls("input/qikOption.php");

// ***********************************************************
HTW::xtag("options");
// ***********************************************************
$qik = new qikOption(); if (DB_MODE)
$qik->getVal("opt.feedback", 0);
$qik->getVal("opt.tooltip", 0);
$qik->show();

?>
