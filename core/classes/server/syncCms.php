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

	$this->load("modules/xfer.cms.tpl");
}

// ***********************************************************
public function read($ini = false) {
	$fil = APP::relPath($ini); $this->set("inifile", $fil);
	$ini = FSO::join(APP_FBK, $fil);

	parent::read($ini);

	$this->setSource($this->get("web.url", "???"));
	$this->setTarget(APP_FBK);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
