<?php
# collect sub pages for printable output

incCls("xsite/chapter.php");

// ***********************************************************
// check include file
// ***********************************************************
$inc = PGE::incFile();

switch (STR::left($inc)) {
	case "cal":
	case "col": break;
	default:    $inc = "include.php";
}

// ***********************************************************
// print page(s)
// ***********************************************************
$fil = FSO::join(__DIR__, "doc_$inc");
include $fil;

?>
