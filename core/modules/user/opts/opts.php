<?php

if (SEARCH_BOT) return;
if (TAB_SET == "config") return;
if (VMODE == "search") return;

DBG::file(__FILE__);

// ***********************************************************
HTW::xtag("options", 'div class="h4"');
// ***********************************************************
incCls("input/qikOption.php");

$qik = new qikOption(); if (DB_MODE)
if (CFG::mod("uopts.fback")) $qik->getVal("opt.feedback", 0);
if (CFG::mod("uopts.ttip"))  $qik->getVal("opt.tooltip", 0);
$qik->show();

?>
