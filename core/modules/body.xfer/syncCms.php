<?php

#return MSG::now("Feature currently disabled ...");

if (! IS_LOCAL) {
	return MSG::now("edit.deny");
}

incCls("server/syncCms.php");

// ***********************************************************
$snc = new syncCms("config/ftp_cms.ini");
$snc->upgrade();

?>
