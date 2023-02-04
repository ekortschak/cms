<?php

$typ = PGE::get("props.typ");
$tit = PGE::getTitle();

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
