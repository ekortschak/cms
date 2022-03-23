<?php

if (FTP_MODE == "none") {
	return MSG::now("ftp.disabled");
}
incCls("server/syncDown.php");

$dir = __DIR__;
include_once("$dir/syncUp.htm"); // warnings

$ftp = new syncDown();
$ftp->xfer();

?>
