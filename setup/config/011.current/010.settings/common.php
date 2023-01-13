<?php

incCls("menus/localMenu.php");
incCls("editor/iniMgr.php");

// ***********************************************************
// select destination
// ***********************************************************
$arr = array(
	"ini" => "Localhost",
	"srv" => "Server"
);

$nav = new localMenu();
$ext = $nav->getKey("scope", $arr);
$nav->show();

// ***********************************************************
// read and write data
// ***********************************************************
$tpl = "LOC_CFG/$fcs.ini";
$fil = "config/$fcs.$ext";

$sts = ""; if (! is_file($fil)) $sts = BOOL_NO;

HTW::tag("file = $fil $sts", "small");

$ini = new iniMgr($tpl);
$ini->update($fil);
$ini->show();

?>
