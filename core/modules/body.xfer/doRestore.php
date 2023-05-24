<?php

incCls("menus/dropBox.php");
incCls("server/syncBack.php");

// ***********************************************************
// read options
// ***********************************************************
$set = "local"; if (! IS_LOCAL)
$set = "server";

$dev = CFG::getValues("backup", $set);
$dev = VEC::flip($dev);

$act = array(
	"syncBack" => DIC::get("act.syncback"),
	"restore"  => DIC::get("act.restore"),
	"revert"   => DIC::get("act.revert"),
);

// ***********************************************************
// choose action
// ***********************************************************
$box = new dropBox("menu");
$fnc = $box->getKey("pic.mode", $act);
$dev = $box->getKey("pic.medium", $dev); // backup media
$xxx = $box->show();

if (! FSO::hasXs($dev)) return;

// ***********************************************************
// transfer files
// ***********************************************************
$snc = new syncBack($dev);
$snc->$fnc();

?>
