<?php

incCls("input/qikOption.php");

// ***********************************************************
// handle options
// ***********************************************************
$arr = array(
	"opt.feedback" => 0,
	"opt.tooltip" => 0,
);

if (! VEC::get($cfg, "uopts.fback")) unset($arr["opt.feedback"]);
if (! DB_MODE) unset($arr["opt.feedback"]);

// ***********************************************************
HTW::xtag("options");
// ***********************************************************
$qik = new qikOption();
$qik->getVal("opt.feedback", 0);
$qik->getVal("opt.tooltip", 0);
$qik->show();

?>
