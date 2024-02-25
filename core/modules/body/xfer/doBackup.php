<?php

incCls("menus/dropBox.php");
incCls("server/syncArc.php");

// ***********************************************************
// read options
// ***********************************************************
$set = "local"; if (! IS_LOCAL)
$set = "server";

$dev = CFG::iniGroup("backup:$set");
$dev = VEC::flip($dev);

$act = array(
	"sync"    => DIC::get("act.sync"),
	"backup"  => DIC::get("act.backup"), 	"x" => "<hr class='low'>",
	"version" => DIC::get("act.version"),	"y" => "<hr class='low'>",
	"manage"  => DIC::get("act.manage")
);

// ***********************************************************
// choose action
// ***********************************************************
$box = new dropBox("menu");
$fnc = $box->getKey("pic.mode", $act);
$dev = $box->getKey("pic.medium", $dev); // backup media
$xxx = $box->show();

if (! FSO::hasXs($dir)) {
	return MSG::now("no.access");
}

if ($fnc == "manage") {
	include_once "exManage.php";
	return;
}

// ***********************************************************
// define archive dir
// ***********************************************************
LOC::setArchive($dev);

// ***********************************************************
// transfer files
// ***********************************************************
$snc = new syncArc();
$snc->$fnc();

?>
