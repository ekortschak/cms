<?php

incCls("menus/dropBox.php");
incCls("editor/iniMgr.php");

// ***********************************************************
// select destination
// ***********************************************************
$arr = array(
	"ini" => "Localhost",
	"srv" => "Server"
);

$nav = new dropBox("menu");
$ext = $nav->getKey("scope", $arr);
$nav->show();

// ***********************************************************
// read and write data
// ***********************************************************
$tpl = "LOC_CFG/$fcs.def";
$ful = "config/$fcs.$ext";

$sts = ""; if (! is_file($ful)) $sts = BOOL_NO;

HTW::tag("file = $ful $sts", "small");

$ini = new iniMgr($tpl);
$ini->exec($ful);
$ini->show();

?>
