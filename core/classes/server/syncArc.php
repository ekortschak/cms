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

incCls("menus/dropBox.php");
incCls("server/sync.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class syncArc extends sync {
	protected $dev = ARCHIVE;  // storage device

function __construct() {
	parent::__construct();

	$this->load("modules/xfer.backup.tpl");
	$this->setVisOnly(false);
}

// ***********************************************************
// set parameters
// ***********************************************************
public function setDevice($dev = ARCHIVE) {
	$this->dev = $dev;
	$this->setTarget($dev);
}

// ***********************************************************
// run jobs (backup mode)
// ***********************************************************
public function backup() {
	$dir = APP::arcDir($this->dev, "bkp");
	$dir = FSO::join($dir, date("Y.m.d"));

	$this->setTarget($dir);
	$this->run("backup");
}

// ***********************************************************
public function sync() {
	$this->run("sync");
}

// ***********************************************************
public function version() {
	$dir = APP::arcDir($this->dev, "ver");
	$dir = FSO::join($dir, VERSION);

	$this->setTarget($dir);
	$this->run("version");
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
