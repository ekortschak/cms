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

$nav = new dropBox();
$ext = $nav->getKey("scope", $arr);
$nav->show("menu");

// ***********************************************************
// read and write data
// ***********************************************************
$tpl = "design/config/$fcs.ini";
$fil = "config/$fcs.$ext";

if (! is_file($fil))
MSG::now("file.missing");

HTM::cap("file = $fil", "small");

$ini = new iniMgr($tpl);
$ini->update($fil);
$ini->show();

?>
