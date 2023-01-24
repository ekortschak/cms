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

incCls("menus/dropBox.php");
incCls("server/syncArc.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class syncBack extends syncArc {

function __construct() {
	parent::__construct();

	$this->load("modules/xfer.backup.tpl");
}

// ***********************************************************
// run jobs (restore mode)
// ***********************************************************
public function restore() {
	$vrs = $this->getBackups();
	if (! $vrs) return MSG::now("restore.none");

	$box = new dropBox();
	$xxx = $box->suit("menu");
	$dst = $box->getKey("as of", $vrs);
	$mnu = $box->gc();

	$this->setTarget($dst);
	$this->revertFlow();
	$this->set("choices", $mnu);
	$this->run("restore");
}

// ***********************************************************
public function syncBack($version = NV) {
	$dst = $this->get("target");
	if (! is_dir($dst)) return MSG::now("sync.none", $dst);

	$this->revertFlow();
	$this->run("syncBack");
}

// ***********************************************************
public function revert($version = NV) {
	$vrs = $this->getVersions();
	if (! $vrs) return MSG::now("versions.none");

	$box = new dropBox();
	$xxx = $box->suit("inline");
	$dst = $box->getKey("as of", $vrs);
	$vrs = $box->gc();

	$this->set("head", $vrs);
	$this->setTarget($dst);
	$this->revertFlow();
	$this->run("revert");
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
protected function revertFlow() {
	$src = $this->get("source");
	$dst = $this->get("target");
	
	$this->set("source", $dst);
	$this->set("target", $src);
}

// ***********************************************************
protected function getBackups() {
	$dir = APP::arcDir($this->dev, "bkp");
	return FSO::folders("$dir/*");
}

// ***********************************************************
protected function getVersions() {
	$dir = APP::arcDir($this->dev, "ver");
	return FSO::folders("$dir/*");
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
