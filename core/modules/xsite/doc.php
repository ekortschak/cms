<?php

if (PGE::skip()) return;

PGE::pbreak();

// ***********************************************************
// check include file
// ***********************************************************
$inc = PGE::incFile();

switch (STR::left($inc)) {
	case "cal": break;
	default:    $inc = "include.php";
}

// ***********************************************************
// print page(s)
// ***********************************************************
$fil = FSO::join(__DIR__, "doc_$inc");
include $fil;

?>
