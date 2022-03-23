<?php

if (FTP_MODE == "none") {
	return MSG::now("ftp.disabled");
}

if (! is_dir(APP_FBK."core")) {
	return MSG::now("cms.sync");
}

incCls("server/syncCms.php");

$dir = __DIR__;
include_once("$dir/syncCms.htm"); // warnings

$ftp = new syncCms();
$ftp->xfer();

?>
