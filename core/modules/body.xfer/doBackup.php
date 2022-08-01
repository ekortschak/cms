<?php

incCls("menus/dropbox.php");
incCls("server/backup.php");

// ***********************************************************
// read options
// ***********************************************************
$ini = new ini("config/backup.ini");
$dev = $ini->getValues("local");
$dev = array_flip($dev);

$act = array(
	"sync"   => DIC::get("act.sync"),
	"backup" => DIC::get("act.backup")
);

// ***********************************************************
// choose action
// ***********************************************************
$box = new dbox();
$fnc = $box->getKey("pic.mode", $act);
$dev = $box->getKey("pic.medium", $dev); // backup media
$xxx = $box->show("menu");

if (! FSO::hasXs($dev)) return;

// ***********************************************************
// transfer files
// ***********************************************************
$snc = new backup();
$snc->setDevice($dev);
$snc->$fnc();

?>
