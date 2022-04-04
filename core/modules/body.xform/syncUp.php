<?php

if (FTP_MODE == "none") {
	return MSG::now("ftp.disabled");
}

// ***********************************************************
$act = ENV::get("sync");
$pnd = ENV::get("ftp.pend");

$snc = $act; if ($snc) $snc = 0; else $snc = 1;

$tpl = new tpl();
$tpl->read("design/templates/editor/mnuSync.tpl");
$tpl->set("sync", $snc);
$tpl->show("info"); if ($snc)
$tpl->copy("act.reset", "act");
$tpl->show();

if ($snc == 0) return;
if ($act) ENV::set("ftp.pend", "act");

// ***********************************************************
incCls("server/syncUp.php");

$ftp = new syncUp();
$ftp->xfer();

?>
