<?php

ENV::setIf("opt.tooltip", 1);

ENV::setIf("survey.ID", "Ewigkeit");
ENV::setIf("survey.who", uniqid());

// ***********************************************************
incCls("menus/buttons.php");
// ***********************************************************
$btn = ENV::getPost("nav", "x");
$btn = ENV::get("survey.done", $btn);
$don = false;
$act = "doSurvey";

switch($btn) {
	case "Fertig":
		$don = ENV::set("survey.done", true); break;
}

$dir = FSO::mySep(__DIR__);

$nav = new buttons("menu", "I", $dir);
$nav->add("I", "doInfo");
$nav->add("D", "doReset");

if (! $don) {
	$nav->add("U", "doSurvey");
}
else {
	$nav->revert("U", "S");

	$nav->add("S", "doSave");
	$nav->add("R", "doResults");
}
$nav->show();

$nav->showContent();

?>
