<?php

incCls("input/qikOption.php");

// ***********************************************************
// handle options
// ***********************************************************
$dbs = (bool) DB_MODE; if (DB_MODE == "false") $dbs = false;

// ***********************************************************
HTW::xtag("options");
// ***********************************************************
$qik = new qikOption();
if ($dbs)
$qik->getVal("opt.feedback", 0);
$qik->getVal("opt.tooltip", 0);
$qik->show();

?>
