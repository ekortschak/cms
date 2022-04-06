<?php

if (FTP_MODE == "none") {
	return MSG::now("ftp.disabled");
}

if (! is_dir(APP_FBK."core")) {
	return MSG::now("cms.sync");
}

// ***********************************************************
$snc = ENV::get("sync", 0);
$snc = $act = (bool) $snc; $snc = ! $snc;

$tpl = new tpl();
$tpl->read("design/templates/editor/mnuSync.tpl");
$tpl->set("sync", $snc);
$tpl->show("cms"); if ($act)
$tpl->copy("act.reset", "act");
$tpl->show();

if (! $act) return;

ENV::set("ftp.pend", "act");

// ***********************************************************
incCls("server/syncCms.php");

$ftp = new syncCms();
$ftp->xfer();

?>
