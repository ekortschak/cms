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

function __construct($dev) {
	parent::__construct($dev);

	$this->load("modules/xfer.backup.tpl");

	$this->setVisOnly(false);
	$this->setSource(APP_DIR);
	$this->setTarget($dir);
}

// ***********************************************************
// run jobs (backup mode)
// ***********************************************************
public function sync() {
	$dir = LOC::arcDir("sync");
	return $this->common($dir, "sync");
}

public function backup() {
	$dir = LOC::arcDir("bkp", date("Y.m.d"));
	return $this->common($dir, "backup");
}

public function version() {
	$dir = LOC::arcDir("ver", VERSION);
	return $this->common($dir, "version");
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
protected function common($dir, $sec) {
	if (! $this->trgPath) $this->setTarget($dir);
	return $this->run($sec);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
