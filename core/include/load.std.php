<?php

$mod = ENV::get("vmode", "view");

switch ($mod) {
	case "csv": $dst = "csv"; break; // retrieve data only
	case "prn": $dst = "prn"; break; // printing and pdf
	default:    $dst = "screen";
}
CFG::set("VMODE", $mod);
CFG::set("CUR_DEST", $dst);

// ***********************************************************
// load local constants and classes (if any)
// ***********************************************************
$lcl = FSO::join(LOC_INC, "main.php");
$lcl = APP::file($lcl);

if ($lcl)
include_once $lcl;
include_once "defaults.php";

// ***********************************************************
// benchmark
// ***********************************************************
# TMR::punch("inc.std");

?>
