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
	$this->trgHost = APP_DIR;
}

// ***********************************************************
// run jobs (restore mode)
// ***********************************************************
public function syncBack() {
	$dir = APP::arcDir($this->dev, "sync");
	if (! is_dir($dir)) return MSG::now("sync.none", $dir);

	$this->source($dir);
	$this->run("syncBack");
}

// ***********************************************************
public function restore() {
	$vrs = $this->getVersions("bkp");
	if (! $vrs) return MSG::now("restore.none");

	$box = new dropBox("menu");
	$dir = $box->getKey("as of", $vrs);
	$mnu = $box->gc();

	$this->source($dir);
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
	$dir = APP::arcDir($this->dev, $typ);
	return FSO::folders($dir);
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
protected function source($dir) {
	$this->setSource($dir);
	$this->srcHost = $dir;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
