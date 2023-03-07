<?php

if (FTP_MODE == "none") {
	return MSG::now("ftp.disabled");
}

incCls("server/syncCms.php");

// ***********************************************************
$snc = new syncCms();
$snc->read("config/ftp_cms.ini");
$snc->upgrade();

?>
