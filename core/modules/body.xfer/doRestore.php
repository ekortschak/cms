<?php

incCls("menus/localMenu.php");
incCls("server/backup.php");

// ***********************************************************
// read options
// ***********************************************************
$ini = new ini("config/backup.ini");
$dev = $ini->getValues("local");
$dev = array_flip($dev);

$act = array(
	"syncBack" => DIC::get("act.syncback"),
	"restore"  => DIC::get("act.restore")
);

// ***********************************************************
// choose action
// ***********************************************************
$box = new localMenu();
$fnc = $box->getKey("pic.mode", $act);
$dev = $box->getKey("pic.medium", $dev); // backup media
$xxx = $box->show();

if (! FSO::hasXs($dev)) return;

// ***********************************************************
// transfer files
// ***********************************************************
$snc = new backup();
$snc->setDevice($dev);
$snc->$fnc();

?>
