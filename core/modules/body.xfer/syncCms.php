<?php

if (FTP_MODE == "none") {
	return MSG::now("ftp.disabled");
}

incCls("server/syncCms.php");

// ***********************************************************
$snc = new syncCms();
$snc->set("head", "Downloading CMS");
$snc->upgrade();

?>
