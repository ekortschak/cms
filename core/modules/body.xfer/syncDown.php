<?php

if (FTP_MODE != "passive") {
	return MSG::now("ftp.disabled");
}

if (! IS_LOCAL) {
	return MSG::now("edit.deny");
}

incCls("server/syncDown.php");

// ***********************************************************
$snc = new syncDown("config/ftp.ini");
$snc->upgrade();

?>
