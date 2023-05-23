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
	$this->srcHost = APP_DIR;
}

// ***********************************************************
// run jobs (backup mode)
// ***********************************************************
public function sync() {
	$dir = APP::arcDir($this->dev, "sync");
	$this->common($dir, "sync");
}

// ***********************************************************
public function backup() {
	$dir = APP::arcDir($this->dev, "bkp", date("Y.m.d"));
	$this->common($dir, "backup");
}

// ***********************************************************
public function version() {
	$dir = APP::arcDir($this->dev, "ver", VERSION);
	$this->common($dir, "version");
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
protected function common($dir, $sec) {
	$this->setTarget($dir);
	$this->trgHost = $dir;
	$this->run($sec);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
