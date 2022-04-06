<?php

if (FTP_MODE == "none") {
	return MSG::now("ftp.disabled");
}

// ***********************************************************
$snc = ENV::get("sync", 0);
$snc = $act = (bool) $snc; $snc = ! $snc;

$tpl = new tpl();
$tpl->read("design/templates/editor/mnuSync.tpl");
$tpl->set("sync", $snc);
$tpl->show("info"); if ($act)
$tpl->copy("act.reset", "act");
$tpl->show();

if (! $act) return;

ENV::set("ftp.pend", "act");

// ***********************************************************
incCls("server/syncDown.php");

$ftp = new syncDown();
$ftp->xfer();

?>
