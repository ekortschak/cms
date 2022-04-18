<?php

if (FTP_MODE == "none") {
	return MSG::now("ftp.disabled");
}

// ***********************************************************
$pnd = ENV::get("ftp.pend");
$snc = ENV::get("sync", 0);
$snc = $act = (bool) $snc; $snc = ! $snc;

$tpl = new tpl();
$tpl->read("design/templates/editor/mnuSync.tpl");
$tpl->set("sync", $snc);
$tpl->show("info"); if ($act)
$tpl->copy("act.reset", "act");
$tpl->show();

if (! $act) return;
if (! is_array($pnd)) ENV::set("ftp.pend", "act");

// ***********************************************************
incCls("server/syncUp.php");

$ftp = new syncUp();
$ftp->xfer();

?>
