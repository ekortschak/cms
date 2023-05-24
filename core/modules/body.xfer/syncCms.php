<?php

if (! IS_LOCAL) {
	return MSG::now("edit.deny");
}

return MSG::now("Feature currently disabled ...");

incCls("server/syncCms.php");

// ***********************************************************
$snc = new syncCms("config/ftp_cms.ini");
$snc->upgrade();

?>
