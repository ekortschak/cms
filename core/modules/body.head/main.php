<?php

$tit = PGE::title();
$typ = PGE::type();

HTW::tag($tit, "div class='h2'");
DBG::file(__FILE__);

// ***********************************************************
// specific tasks
// ***********************************************************
switch (STR::left($typ)) {
	case "cha": $inc = "chapters"; break;
	default:    return;
}

APP::inc(__DIR__, "$inc.php");

?>

