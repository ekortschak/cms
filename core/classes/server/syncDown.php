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

function __construct($inifile) {
	parent::__construct(false);

	$this->load("modules/xfer.syncDown.tpl");
	$this->read($inifile);

	$this->setSource(APP_DIR);
	$this->setTarget(APP_DIR);

	$this->srcHost = $this->get("web.url", "???");
	$this->trgHost = APP_DIR;

	$this->srcVer = $this->srvVersion();
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
// ***********************************************************
protected function do_copy($fso) { // single file op
	if ( ! $this->htp) return false;

	$fso = APP::relPath($fso);

	$txt = $this->htp->query("dwn", $fso);
	$txt = $this->stripInf($txt);
	$erg = APP::write($fso, $txt);

	return (bool) $erg;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
