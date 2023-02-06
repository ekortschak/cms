<?php
/* ***********************************************************
// INFO
// ***********************************************************
Designed to sync local project to server ...
* settings: config/ftp.ini

// ***********************************************************
// HOW TO USE
// ***********************************************************
$snc = new syncUp();
$snc->read("ftp.ini");
$snc->publish();
*/

incCls("server/syncUp.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class syncDist extends syncUp {

function __construct() {
	parent::__construct();
}

// ***********************************************************
// find versions
// ***********************************************************
protected function correct($ver) {
	return STR::replace($ver, APP_NAME, "cms"); // force to cms
}

protected function getCms() {
	return APP_FBK;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
