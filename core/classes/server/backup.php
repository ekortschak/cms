<?php
/* ***********************************************************
// INFO
// ***********************************************************
used for local backup and restore

// ***********************************************************
// HOW TO USE
// ***********************************************************
$bkp = new backup($bkpDir);
$bkp->backup($dir);
*/

incCls("server/sync.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class backup extends sync {

function __construct() {
	parent::__construct();
}

// ***********************************************************
// local backups
// ***********************************************************
public function restore($src, $dest) { // copy data from backup directory
	$this->exec($src, $dest);
	$this->report("Restore", $dest);
}

public function backup($src, $dest) { // copy data to backup directory
	$this->exec($src, $dest);
	$this->report("Backup", $src);
}

protected function exec($src, $dest = "") {
    if (! $dest) return; FSO::force($dest);
    parent::exec($src, $dest);
}

protected function srcName($fso) {
	if (STR::begins($fso, $this->src)) return $fso;
	return FSO::join($this->src, $fso);
}
protected function destName($fso) {
	if (STR::begins($fso, $this->dst)) return $fso;
	return FSO::join($this->dst, $fso);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
