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

function __construct($ftp) {
	parent::__construct(false);

	$this->load("modules/xfer.syncDown.tpl");
	$this->read($ftp);

	$this->setSource(APP_DIR);
	$this->setTarget(APP_DIR);

	$this->set("source", $this->get("web.url", "???"));
	$this->set("vsrc",   $this->srvVersion());
}

// ***********************************************************
// run jobs
// ***********************************************************
public function upgrade() {
	parent::run();
}

// **********************************************************
protected function getTree($src, $dst) {
	$src = $this->srvFiles();
	$dst = $this->lclFiles($dst);
	$out = $this->getNewer($src, $dst);

	$out = $this->chkProtect($out);
	$out = $this->chkRename($out);
	$out = $this->chkCount($out);
	return $out;
}

// ***********************************************************
// overwrite file actions
// **********************************************************
protected function manage($act, $fso) {
	switch ($act) {
		case "cpf": return $this->do_down($fso); break;
	}
	return parent::manage($act, $fso);
}

// ***********************************************************
protected function do_down($fso) { // single file op
	if ( ! $this->htp) return false;

	$txt = $this->htp->query("dwn", $fso);
	$txt = $this->stripInf($txt);
	$fso = $this->trgName($fso);

	return APP::write($fso, $txt);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
