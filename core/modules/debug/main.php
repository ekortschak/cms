<?php

DBG::file(__FILE__);

// ***********************************************************
$arr = array(
	"T" => "Tab Properties",
	"M" => "Menu Properties",
	"P" => "Menu Tree",
	"I" => "Page Properties",
);

// ***********************************************************
HTW::xtag("dbg.opts", "h3");
// ***********************************************************
incCls("menus/dropBox.php");

$box = new dropBox("menu");
$wht = $box->getKey("pic.show", $arr, "S");
$box->show();

switch ($wht) {
	case "T": $inc = "doTab";  break;
	case "M": $inc = "doMenu"; break;
	case "I": $inc = "doIni";  break;
	case "P": $inc = "doPFS";  break;
}

APP::inc(__DIR__, "$inc.php");

?>
