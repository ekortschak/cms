<?php

if (FTP_MODE == "none") {
	return MSG::now("ftp.disabled");
}

incCls("server/syncDown.php");

// ***********************************************************
$snc = new syncDown("config/ftp.ini");
$snc->upgrade();

?>
