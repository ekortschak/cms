<?php
/* ***********************************************************
// INFO
// ***********************************************************
Designed to sync latest CMS version to local CMS ...

// ***********************************************************
// HOW TO USE
// ***********************************************************
see parent class
*/

incCls("server/syncDown.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class syncCms extends syncDown {

function __construct() {
	parent::__construct();

	$this->ftp = new ftp();

	$this->read("config/ftp_cms.ini");
	$this->load("modules/xfer.cms.tpl");
	$this->setTarget(APP_FBK);
}

// ***********************************************************
public function read($ini = false) {
	$fil = APP::relPath($ini); $this->set("inifile", $fil);
	$ini = FSO::join(APP_FBK, $ini);

	parent::read($ini);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
