<?php

$arr = array(
	"C" => "Constants",
	"V" => "Server Vars",
	"S" => "Session Vars",
	"T" => "Tab Properties",
	"M" => "Menu Properties",
	"P" => "Menu Tree",
	"I" => "Page Properties",
	"L" => "Log Files",
	"X" => "Stylesheet",
);
$div = STR::toArray(".env.pfs.oid.tan.");

$ptn = FSO::join(LOG::dir(), "*");
$fls = FSO::files($ptn);

// ***********************************************************
HTM::tag("dbg.opts", "h3");
// ***********************************************************
incCls("menus/localMenu.php");

$box = new localMenu();
$wht = $box->getKey("pic.show", $arr, "S"); if ($wht == "L")
$ful = $box->getKey("pic.file", $fls, "parms.log"); if ($wht == "S")
$div = $box->getKey("div",  $div, "env");
$box->show();

switch ($wht) {
	case "C": include("doConst.php");  break;
	case "V": include("doServer.php"); break;
	case "T": include("doTab.php");    break;
	case "M": include("doMenu.php");   break;
	case "I": include("doIni.php");    break;
	case "P": include("doPFS.php");    break;
	case "L": include("doLog.php");    break;
	case "X": include("doCss.php");    break;
	default:  include("doEnv.php");
}

?>
