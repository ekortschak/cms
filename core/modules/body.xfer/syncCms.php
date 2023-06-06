<?php

#return MSG::now("Feature currently disabled ...");

if (! IS_LOCAL) {
	return MSG::now("edit.deny");
}

incCls("server/syncCms.php");

// ***********************************************************
$fil = FSO::join(APP_FBK, "config", "ftp.ini");

$snc = new syncCms($fil);
$snc->upgrade();

?>
