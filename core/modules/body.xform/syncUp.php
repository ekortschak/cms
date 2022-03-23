<?php

if (FTP_MODE == "none") {
	return MSG::now("ftp.disabled");
}
incCls("server/syncUp.php");

$dir = __DIR__;
include_once("$dir/syncUp.htm"); // warnings

$ftp = new syncUp();
$ftp->xfer();

?>
