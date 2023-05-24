<?php

$loc = ENV::getPage();

$typ = PGE::get("props.typ");
$tit = PGE::getTitle($loc);

HTW::tag($tit, "h3");

// ***********************************************************
// specific tasks
// ***********************************************************
switch (STR::left($typ)) {
	case "cha": $inc = "chapters"; break;
	default: return;
}

include APP::getInc(__DIR__, "$inc.php");

?>

