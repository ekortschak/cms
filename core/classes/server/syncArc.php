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
public function sync($app = APP_NAME) {
	$dir = LOC::arcDir($app, "sync");
	$out = $this->common($dir, "sync");

	if ($out) LOG::clear($app, "sync");
	return $out;
}

public function backup($app = APP_NAME) {
	$dir = LOC::arcDir($app, "bkp", date("Y.m.d"));
	return $this->common($dir, "backup");
}

public function version($app = APP_NAME) {
	$dir = LOC::arcDir($app, "ver", VERSION);
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
