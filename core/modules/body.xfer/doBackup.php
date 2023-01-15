<?php

incCls("menus/dropMenu.php");
incCls("server/backup.php");

// ***********************************************************
// read options
// ***********************************************************
$ini = new ini("config/backup.ini");
$dev = $ini->getValues("local");
$dev = array_flip($dev);

$act = array(
	"sync"    => DIC::get("act.sync"),
	"backup"  => DIC::get("act.backup"), 	"x" => "<hr class='low'>",
	"version" => DIC::get("act.version"),	"y" => "<hr class='low'>",
	"manage"  => DIC::get("act.manage")
);

// ***********************************************************
// choose action
// ***********************************************************
$box = new dropMenu();
$fnc = $box->getKey("pic.mode", $act);
$dev = $box->getKey("pic.medium", $dev); // backup media
$xxx = $box->show();

if (! FSO::hasXs($dev)) return;

if ($fnc == "manage") {
	include APP::getInc(__DIR__, "exManage.php");
	return;
}

// ***********************************************************
// transfer files
// ***********************************************************
$snc = new backup();
$snc->setDevice($dev);
$snc->$fnc();

?>
