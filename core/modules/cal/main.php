<?php

DBG::file(__FILE__);

// ***********************************************************
# props.date required in page inifile
$dat = PGE::get("props.cal.date");
if (! $dat) return;

// ***********************************************************
APP::inc(__DIR__, "month.php");

?>
