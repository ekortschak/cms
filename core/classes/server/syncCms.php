<?php
/* ***********************************************************
// INFO
// ***********************************************************
Designed to sync server to local project ...

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("server/syncDown.php");

$pub = new syncDown($inifile);
$pub->xfer();

*/

incCls("input/confirm.php");
incCls("server/syncDown.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class syncCms extends syncDown {

function __construct() {
	parent::__construct();

	$this->src = ".";
	$this->dst = APP_FBK;

	$this->ftp->read("$this->dst/config/ftp_cms.ini");
}

// ***********************************************************
// acting
// ***********************************************************
protected function ask() {
	$url = $this->ftp->get("web.url");
	$msg = DIC::get("cms.update");
	$frm = DIC::get("from");

	$cnf = new confirm();
	$cnf->head($msg);
	$cnf->add("$frm <a href='https://$url' target='_blank'>$url</a>");
	$cnf->add("&rarr; $this->dst");
	$cnf->show();

	return $cnf->act();
}

// **********************************************************
// retrieving data for action
// **********************************************************
protected function getTree($src, $dst) {
	$src = $this->webList($src); if (! $src) return false;
	$dst = $this->getList($dst); if (! $dst) return false;
	$out = $this->getNewer($src, $dst);
#	$out = $this->filter($out);
	$out = $this->chkCount($out);
	return $out;
}

protected function filter($lst) {
	$out = array(); unset($lst["man"]);

	foreach ($lst as $grp) {
		foreach ($grp as $fso => $prp) {
			if (STR::contains($fso, "config/")) continue;
			if (STR::contains($fso, "pages/")) continue;
			$out[$fso] = $prp;
		}
	}
	return $out;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
