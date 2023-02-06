<?php
/* ***********************************************************
// INFO
// ***********************************************************
Designed to sync server to local project ...
* settings: config/ftp.ini

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("server/syncDown.php");

$snc = new syncDown();
$snc->read("ftp.ini");
$snc->upgrade();

*/

incCls("server/syncServer.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class syncDown extends syncServer {

function __construct() {
	parent::__construct();
	
	$this->load("modules/xfer.syncDown.tpl");

	$this->setSource($this->get("web.url", "???"));
	$this->setTarget(APP_DIR);
}

//// ***********************************************************
// run jobs
// ***********************************************************
public function upgrade() {
	parent::run();
}

// **********************************************************
protected function getTree($src, $dst) {
	$src = $this->FSremote();    if (! $src) return false; // remote
	$dst = $this->FSlocal($dst); if (! $dst) return false; // local files
	$out = $this->getNewer($src, $dst);

	$out = $this->chkProtect($out);
	$out = $this->chkRename($out);
	$out = $this->chkCount($out);
	return $out;
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
protected function srcName($fso, $act = false) {
	$rut = $this->get("ftp.froot"); if (STR::begins($fso, $rut)) return $fso;
	return FSO::join($rut, $fso);
}

protected function srcVersion() {
	return $this->remoteVersion();
}

// ***********************************************************
// overwrite file actions
// ***********************************************************
protected function do_copy($src, $dst) { // single file op
	return $ftp->save($src, $dst);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
