<?php

incCls("menus/dropbox.php");

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

$ptn = FSO::join(LOG::dir(), "*");
$fls = FSO::files($ptn);

// ***********************************************************
HTM::tag("opt.dbg", "h3");
// ***********************************************************
$box = new dbox();
$wht = $box->getKey("Show", $arr, "S"); if ($wht == "L")
$ful = $box->getKey("file", $fls, "parms.log");
$box->show("menu");

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
