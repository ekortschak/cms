<p>Schwerer Fehler: beim Download können derzeit Dateien verschwinden. Problem noch nicht behoben.</p>


<?php
return;

if (FTP_MODE == "none") {
	return MSG::now("ftp.disabled");
}

incCls("server/syncCms.php");

// ***********************************************************
$snc = new syncCms("config/ftp_cms.ini");
$snc->upgrade();

?>
