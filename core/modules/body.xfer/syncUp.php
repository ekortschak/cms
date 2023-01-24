<?php

if (FTP_MODE == "none") {
	return MSG::now("ftp.disabled");
}

incCls("server/syncUp.php");

// ***********************************************************
$snc = new syncUp();
$snc->read("config/ftp.ini");
$snc->publish();

?>

