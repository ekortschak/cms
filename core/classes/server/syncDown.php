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

	$src = FSO::clearRoot($src);
	$src = FSO::join($pfx, $src);
	$dst = $this->destName($dst);

	return $this->ftp->save($src, $dst);
}

// ***********************************************************
protected function fsRen($fso) {
	$prp = explode("|", $fso); if (count($prp) < 3) return false;

	$src = $this->lclName($fso);
	$dst = $this->destName($fso);

	return (bool) FSO::rename($src, $dst);
}

protected function mkDir($dst) {
	$dst = $this->destName($dst);
	return (bool) FSO::force($dst);
}
protected function rmDir($dst) {
	$dst = $this->destName($dst); if ($dst == APP_DIR) return false;
	return (bool) FSO::rmDir($dst);
}
protected function kill($dst)  {
	$dst = $this->destName($dst);
	return (bool) FSO::kill($dst);
}

// ***********************************************************
protected function lclName($fso) {
	if (! $fso) return false; $src = $this->src; if ($dst == ".") $dst = APP_DIR;
	if (STR::begins($fso, $src)) return $fso;
	$src = FSO::join($src, $fso);
	return $src;
}
protected function destName($fso) {
	if (! $fso) return false; $dst = $this->dst; if ($dst == ".") $dst = APP_DIR;
	if (STR::begins($fso, $dst)) return $fso;
	$dst = FSO::join($dst, $fso);
	return $dst;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
