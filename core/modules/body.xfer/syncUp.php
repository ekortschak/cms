<?php

if (! IS_LOCAL) {
	return MSG::now("edit.deny");
}

incCls("server/syncUp.php");

// ***********************************************************
$snc = new syncUp("config/ftp.ini");
$snc->publish();

?>

