<?php

incCls("input/confirm.php");
incCls("menus/dropbox.php");
incCls("menus/qikLink.php");
incCls("server/backup.php");

$ini = new ini("config/backup.ini");
$dst = $ini->getValues("local");
$dst = array_flip($dst);

// ***********************************************************
// choose action
// ***********************************************************
$act = array(
	"sync"   => DIC::get("act.sync"),
	"backup" => DIC::get("act.backup")
);

$box = new dbox();
$fnc = $box->getKey("pic.mode", $act);
$bkp = $box->getKey("pic.medium", $dst); // backup media
$xxx = $box->show("menu");

$bkp = FSO::force($bkp); if (! FSO::hasXs($bkp)) return;

// ***********************************************************
// check destination (write access)
// ***********************************************************
$src = APP_DIR;
$dst = FSO::join($bkp, APP_NAME); if ($fnc == "backup")
$dst = FSO::join($dst, "bkp.".date("Y.m.d")); else
$dst = FSO::join($dst, "sync");

// ***********************************************************
// ask for confirmation
// ***********************************************************
$cnf = new confirm();
$cnf->add($act[$fnc]);
$cnf->add($src);
$cnf->add("&rarr; $dst");
$cnf->show();

if (! $cnf->act()) return;

// ***********************************************************
// transfer files
// ***********************************************************
$snc = new backup();
$snc->$fnc($src, $dst);

?>
