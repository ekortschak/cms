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
	default:    $inc = "include";
}

// ***********************************************************
// print page(s)
// ***********************************************************
APP::inc(__DIR__, "doc_$inc.php");

?>
