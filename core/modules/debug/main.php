<?php

$arr = array(
	"T" => "Tab Properties",
	"M" => "Menu Properties",
	"P" => "Menu Tree",
	"I" => "Page Properties",
);

// ***********************************************************
HTW::xtag("dbg.opts", "h3");
// ***********************************************************
incCls("menus/dropMenu.php");

$box = new dropMenu();
$wht = $box->getKey("pic.show", $arr, "S");
$box->show();

switch ($wht) {
	case "T": include "doTab.php";  break;
	case "M": include "doMenu.php"; break;
	case "I": include "doIni.php";  break;
	case "P": include "doPFS.php";  break;
}

?>
