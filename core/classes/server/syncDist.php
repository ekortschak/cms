<?php
/* ***********************************************************
// INFO
// ***********************************************************
Designed to sync local cms to server ...
* settings: config/ftp.ini

// ***********************************************************
// HOW TO USE
// ***********************************************************
see parent class ...
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
	$ver = STR::replace($ver, "/tools", "/kor"); // force to cms
	return STR::replace($ver, APP_NAME, "cms" ); // force to cms
}

protected function getCms() {
	return APP_FBK; // force to cms
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
