<?php
/* ***********************************************************
// INFO
// ***********************************************************
used for local restore

// ***********************************************************
// HOW TO USE
// ***********************************************************
$snc = new syncBack();
$snc->setDevice($dev);
$snc->restore();
*/

incCls("server/sync.php");
incCls("menus/dropBox.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class syncBack extends sync {

function __construct() {
	parent::__construct();

	$this->load("modules/xfer.backup.tpl");
	$this->setVisOnly(false);
}

// ***********************************************************
// run jobs (restore mode)
// ***********************************************************
public function syncBack($app = APP_NAME) {
	$dir = LOC::arcDir($app, "sync");
	if (! is_dir($dir)) return MSG::now("sync.none", $dir);

	$this->setSource($dir);
	$this->run("syncBack");
}

// ***********************************************************
public function restore($app = APP_NAME) {
	$vrs = $this->getVersions($app, "bkp");
	if (! $vrs) return MSG::now("restore.none");

	$box = new dropBox("menu");
	$dir = $box->getKey("as of", $vrs);
	$mnu = $box->gc();

	$this->setSource($dir);
	$this->set("choices", $mnu);
	$this->run("restore");
}

// ***********************************************************
public function revert($app = APP_NAME) {
	$vrs = $this->getVersions($app, "ver");
	if (! $vrs) return MSG::now("versions.none");

	$box = new dropBox("menu"); // inline ?
	$dir = $box->getKey("as of", $vrs);
	$mnu = $box->gc();

	$this->source($dir);
	$this->set("choices", $mnu);
	$this->run("revert");
}

// ***********************************************************
// find available versions
// ***********************************************************
protected function getVersions($app, $typ) {
	$dir = LOC::arcDir($app, $typ);
	return FSO::dirs($dir);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
