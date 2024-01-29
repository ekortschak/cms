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

function __construct($dev) {
	parent::__construct($dev);

	$this->load("modules/xfer.backup.tpl");

	$this->setVisOnly(false);
	$this->setTarget(APP_DIR);
}

// ***********************************************************
// run jobs (restore mode)
// ***********************************************************
public function syncBack() {
	$dir = LOC::arcDir("sync");
	if (! is_dir($dir)) return MSG::now("sync.none", $dir);

	$this->setSource($dir);
	$this->run("syncBack");
}

// ***********************************************************
public function restore() {
	$vrs = $this->getVersions("bkp");
	if (! $vrs) return MSG::now("restore.none");

	$box = new dropBox("menu");
	$dir = $box->getKey("as of", $vrs);
	$mnu = $box->gc();

	$this->setSource($dir);
	$this->set("choices", $mnu);
	$this->run("restore");
}

// ***********************************************************
public function revert() {
	$vrs = $this->getVersions("ver");
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
protected function getVersions($typ) {
	$dir = LOC::arcDir($typ);
	return FSO::dirs($dir);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
