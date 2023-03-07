<?php
/* ***********************************************************
// INFO
// ***********************************************************
Designed to sync local project to server ...
* settings: config/ftp.ini

// ***********************************************************
// HOW TO USE
// ***********************************************************
$snc = new syncUp();
$snc->read("ftp.ini");
$snc->publish();
*/

incCls("server/syncServer.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class syncUp extends syncServer {

function __construct() {
	parent::__construct();

	$this->load("modules/xfer.syncUp.tpl");
}

// ***********************************************************
public function read($inifile) {
	parent::read($inifile);

	$srv = $this->get("web.url", "???");
	$this->setTarget($srv);
}

// ***********************************************************
// run jobs
// ***********************************************************
public function publish() {
	$this->getVersions();
	parent::run();
}

// **********************************************************
// retrieving data for action
// **********************************************************
protected function getTree($src, $dst) {
	if ($this->err) return;

	$src = $this->FSlocal($src); if (! $src) return false; // local files
	$dst = $this->FSremote();    if (! $dst) return false; // remote
	$out = $this->getNewer($src, $dst);

	$out = $this->chkProtect($out);
	$out = $this->chkRename($out);
	$out = $this->chkCount($out);
	return $out;
}

// **********************************************************
protected function aggregate($data) { // prepare for webexec(), reducing pay load
	if (! $this->htp) return $data; $out = array();

	foreach ($data as $act => $lst) {
		if (STR::contains("nwr.man", $act)) continue; // do nothing
		if (STR::contains("cpf", $act)) { // no bulk operations
			$out[$act] = $lst; continue;
		}
		$arr = array(); $str = ""; $idx = 0;

		foreach ($lst as $fso) {
			if (strlen("$str;$fso") < 2000) $str.= "$fso;";
			else { $str = "$fso;"; $idx++; }

			$arr[$idx] = trim($str);
		}
		if ($arr) $out[$act] = $arr;
	}
	return $out;
}

// ***********************************************************
// overwrite file actions
// ***********************************************************
protected function do_copy($src, $dst) { // single file op
	if ($this->ftp) return $this->ftp->remote_put($src, $dst);
	if ($this->crl) return $this->crl->upload($src);
}

// ***********************************************************
protected function do_mkDir($lst) {
	if ($this->htp) { // bulk operation
		$out = $this->htp->query($lst, "mkd");
		return intval($out);
	}
	if ($this->ftp) { // single file op
		return $this->ftp->remote_mkDir($lst);
	}
}

// ***********************************************************
protected function do_ren($lst) {
	if ($this->htp) { // bulk operation
		$out = $this->htp->query($lst, "ren");
		return intval($out);
	}
	$prp = explode("|", $lst); if (count($prp) < 3) return false;
	$old = $this->dstName($prp[2]);
	$new = $this->dstName($prp[1]);

	if ($this->ftp) { // single file op
		return $this->ftp->remote_rename($old, $new);
	}
}

// ***********************************************************
protected function do_rmDir($lst) {
	if ($this->htp) { // bulk operation
		$out = $this->htp->query($lst, "rmd");
		return intval($out);
	}
	if ($this->ftp) { // single file op
		return $this->ftp->remote_rmDir($lst);
	}
}

// ***********************************************************
protected function do_kill($lst) {
	if ($this->htp) { // bulk operation
		$out = $this->htp->query($lst, "dpf");
		return intval($out);
	}
	if ($this->ftp) { // single file op
		return $this->ftp->remote_del($lst);
	}
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
protected function dstName($fso, $act = false) {
	$chk = STR::contains(".cpf.", ".$act."); if (! $chk) return $fso;
	$pfx = $this->get("ftp.froot"); if (STR::begins($fso, $pfx)) return $fso;
	return FSO::join($pfx, $fso);
}

protected function dstVersion() {
	return $this->remoteVersion();
}

// ***********************************************************
// find local (distributable) versions
// ***********************************************************
protected function getVersions() {
	$ver = APP::arcDir(SRV_ROOT, "ver");
	$ver = $this->correct($ver);
	$cms = $this->getCms();

	$arr = array($cms => "Current state");
	$drs = FSO::folders($ver);

	foreach ($drs as $key => $val) {
		$arr[$key] = "Version $val";
	}
	$box = new dropBox("menu");
	$src = $box->getKey("sync.src", $arr);
	$mnu = $box->gc();

	$this->set("choices", $mnu);
	$this->setSource($src);
}

// ***********************************************************
protected function correct($ver) {
	return $ver;
}

protected function getCms() {
	return APP_DIR;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
