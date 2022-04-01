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
$pub->xfer($source, $destination);

*/

incCls("input/confirm.php");
incCls("server/syncUp.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class syncDown extends syncUp {

function __construct() {
	parent::__construct();

	$this->src = ".";
	$this->dst = APP_DIR;
}

// **********************************************************
// retrieving data for action
// **********************************************************
protected function getTree($src, $dst) {
	$src = $this->webList($src); if (! $src) return false; // local files
	$dst = $this->getList($dst); if (! $dst) return false; // remote
	$out = $this->getNewer($src, $dst);
	$out = $this->chkProtect($out);
	$out = $this->chkRename($out);
	$out = $this->chkCount($out);
	return $out;
}

// ***********************************************************
// acting
// ***********************************************************
protected function ask() {
	$url = $this->ftp->get("web.url");
	$msg = DIC::get("data.xfer");
	$frm = DIC::get("from");

	$cnf = new confirm();
	$cnf->head($msg);
	$cnf->add("$frm <a href='http://$url' target='_blank'>$url</a>");
	$cnf->add("&rarr; $this->dst");
	$cnf->show();

	return $cnf->act();
}

protected function aggregate($data) {
	return $data; // no bulk ops on local system
}

// ***********************************************************
// overwrite file actions
// ***********************************************************
protected function copy($src, $dst) { // single file op
	if ($this->isProtected($dst)) return false;

	$pfx = $this->ftp->get("ftp.froot");
	$src = FSO::join($pfx, $dst);
	return $this->ftp->save($src, $dst);
}

// ***********************************************************
protected function fsRen($fso) {
	$prp = explode("|", $fso); if (count($prp) < 3) return false;
	return (bool) FSO::rename($prp[1], $prp[2]);
}

protected function mkDir($dst) {
	return (bool) FSO::force($dst);
}
protected function rmDir($dst) {
	return (bool) FSO::rmDir($dst);
}
protected function kill($dst)  {
	return (bool) FSO::kill($dst);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
