<?php

if (FTP_MODE != "passive") {
	return MSG::now("ftp.disabled");
}

if (! IS_LOCAL) {
	return MSG::now("edit.deny");
}

if (APP_NAME == basename(FBK_DIR)) {
	MSG::now("cms.dist");
	return;
}

incCls("server/syncUp.php");

// ***********************************************************
$snc = new syncUp("config/ftp.ini");
$snc->publish();

?>
