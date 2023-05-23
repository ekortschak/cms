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

function __construct($inifile) {
	parent::__construct($inifile);

	$this->load("modules/xfer.cms.tpl");

	$this->setTarget(APP_FBK);
	$this->trgHost = APP_FBK;
}
// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
