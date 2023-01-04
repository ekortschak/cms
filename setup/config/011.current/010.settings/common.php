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

if (! is_file($fil))
MSG::now("file.missing");
HTW::tag("file = $fil", "small");

$ini = new iniMgr($tpl);
$ini->update($fil);
$ini->show();

?>
