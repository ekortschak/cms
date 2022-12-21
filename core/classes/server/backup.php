<?php
/* ***********************************************************
// INFO
// ***********************************************************
used for local backup and restore

// ***********************************************************
// HOW TO USE
// ***********************************************************
$bkp = new backup();
$snc->setDest($dest);
$bkp->backup();
*/

incCls("menus/dropBox.php");
incCls("server/sync.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class backup extends sync {

function __construct() {
	parent::__construct();
}

// ***********************************************************
// set parameters
// ***********************************************************
public function setDevice($dev = SRV_ROOT) {
	$this->dev = FSO::norm($dev);
	$this->setDest(NV, $dev);
}

// ***********************************************************
// run jobs (backup mode)
// ***********************************************************
public function backup() {
	$this->setTitle("Backup");

	$this->setDest(APP::bkpDir("", $this->dev));
	$this->showInfo();
	$this->run();
}
public function restore($version = NV) {
	$this->setTitle("Restore");

	$vrs = $this->getBackups();
	if (! $vrs) return MSG::now("restore.none");

	$box = new dropBox();
	$dst = $box->getKey("as of", $vrs);
	$vrs = $box->gc("seemless");

	$this->setDest(APP::bkpDir(basename($dst), $this->dev));
	$this->revertFlow();
	$this->showInfo($vrs);
	$this->run();
}

// ***********************************************************
// run jobs (sync mode)
// ***********************************************************
public function sync() {
	$this->setTitle("sync.mirror");
	$this->showInfo();
	$this->run();
}
public function syncBack($version = NV) {
	if (! is_dir($this->dst)) return MSG::now("sync.none", $this->dst);

	$this->setTitle("sync.back");
	$this->revertFlow();
	$this->showInfo();
	$this->run();
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
protected function revertFlow() {
	$tmp = $this->src;
	$this->src = $this->dst;
	$this->dst = $tmp;
}

protected function getBackups() {
	$dir = APP::bkpDir("", $this->dev); $dir = dirname($dir);
	return FSO::folders("$dir/bkp*"); krsort($out);
}

// ***********************************************************
protected function srcName($fso, $act = false) {
	if (STR::begins($fso, $this->src)) return $fso;
	return FSO::join($this->src, $fso);
}
protected function destName($fso, $act = false) {
	if (STR::begins($fso, $this->dst)) return $fso;
	return FSO::join($this->dst, $fso);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
