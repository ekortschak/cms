<?php

if (FTP_MODE != "passive") {
	return MSG::now("ftp.disabled");
}

if (! IS_LOCAL) {
	return MSG::now("edit.deny");
}

incCls("server/syncCms.php");

// ***********************************************************
$fil = APP::fbkFile("config", "ftp.ini");

$snc = new syncCms();
$snc->connect($fil);
$snc->upgrade();

?>
