<?php

incCls("input/confirm.php");
incCls("menus/dropbox.php");
incCls("menus/qikLink.php");
incCls("server/backup.php");

$ini = new ini("config/backup.ini");
$src = $ini->getValues("local");
$src = array_flip($src);

// ***********************************************************
// choose action
// ***********************************************************
$act = array(
	"syncback" => DIC::get("act.syncback"),
	"restore"  => DIC::get("act.restore")
);

$box = new dbox();
$fnc = $box->getKey("pic.mode", $act);
$bkp = $box->getKey("pic.medium", $src); // backup media
$xxx = $box->show("menu");

$dst = APP_DIR;
$src = FSO::join($bkp, APP_NAME);

// ***********************************************************
// choose backup on given medium
// ***********************************************************
if ($fnc == "restore") {
	$arr = FSO::folders("$src/bkp*");

	if ($arr) {
		$xxx = $box->setSpaces(-3, 0);
		$src = $box->getKey("as of", $arr);
		$xxx = $box->show("menu");
	}
}
else {
	$src = FSO::join($src, "sync");
}

if (! is_dir($src)) return MSG::now("no.restore");

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
$snc = new syncBacl();
$snc->$fnc($src, $dst);

?>
