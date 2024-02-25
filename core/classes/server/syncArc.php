<?php
/* ***********************************************************
// INFO
// ***********************************************************
used for local backup

// ***********************************************************
// HOW TO USE
// ***********************************************************
$snc = new syncArc();
$snc->setDevice($dev);
$snc->backup();
*/

incCls("server/sync.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class syncArc extends sync {

function __construct() {
	parent::__construct();

	$this->load("modules/xfer.backup.tpl");
	$this->setVisOnly(false);
}

// ***********************************************************
// run jobs (backup mode)
// ***********************************************************
public function sync() {
	$dir = LOC::arcDir(APP_NAME, "sync");
	return $this->common($dir, "sync");
}

public function backup() {
	$dir = LOC::arcDir(APP_NAME, "bkp", date("Y.m.d"));
	return $this->common($dir, "backup");
}

public function version() {
	$dir = LOC::arcDir(APP_NAME, "ver", VERSION);
	return $this->common($dir, "version");
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
protected function common($dir, $sec) {
	$xxx = $this->setTarget($dir);
	return $this->run($sec);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
