<?php
/* ***********************************************************
// INFO
// ***********************************************************
Designed to sync server to local project ...

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("server/syncDown.php");

$pub = new syncDown($inifile);
$pub->xfer();

*/

incCls("server/syncDown.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class syncCms extends syncDown {

function __construct() {
	parent::__construct();

	$this->set("info", false);

	$this->ftp = new ftp();
	$this->read(APP_FBK."/config/ftp_cms.ini");
	$this->setDest(APP_FBK);
}

public function upgrade($version = NV) {
	if (! $this->ftp->test()) return;

	$this->setTitle("sync.cms");
	$this->showInfo();
	$this->run();
}


// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
