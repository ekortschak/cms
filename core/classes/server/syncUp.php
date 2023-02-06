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

incCls("server/sync.php");
incCls("server/http.php");
incCls("server/curl.php");
incCls("server/ftp.php");
incCls("server/SSL.php");

incCls("menus/dropBox.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class syncUp extends sync {
	protected $htp;	// http object
	protected $ftp;	// ftp object

function __construct() {
	parent::__construct();

	$this->ftp = new ftp();

	$this->read();
	$this->load("modules/xfer.syncUp.tpl");
}

// ***********************************************************
public function read($ini = false) {
	$this->ftp->read($ini);

	$dst = $this->ftp->get("web.url", "???");
	$dst = $this->setTarget($dst);

	$this->htp = new http($dst);
}

// ***********************************************************
// run jobs
// ***********************************************************
public function publish() {
	$this->getVersions();
	parent::run();
}

protected function isGood() {
	return $this->ftp->test();
}

// **********************************************************
// retrieving data for action
// **********************************************************
protected function getTree($src, $dst) {
	$src = $this->FSlocal($src); if (! $src) return false; // local files
	$dst = $this->FSremote();    if (! $dst) return false; // remote
	$out = $this->getNewer($src, $dst);

	$out = $this->chkProtect($out);
	$out = $this->chkRename($out);
	$out = $this->chkCount($out);
	return $out;
}

// ***********************************************************
// pass through methods
// ***********************************************************
protected function FSremote() {
	if (! NET::isCon()) {
		$this->error = "nocon"; return;
	}
	return $this->htp->query(".", "get");
}

protected function aggregate($data) { // prepare for webexec()
	return $this->htp->aggregate($data);
}

// **********************************************************
// check for protected files
// **********************************************************
protected function chkProtect($arr) {
	foreach ($arr as $act => $itm) {
		foreach ($itm as $fso) {
			if (! $this->ftp->isProtected($fso)) continue;
			$arr[$act] = VEC::drop($arr[$act], $fso);
			$arr["man"][] = $fso;
		}
	}
	return $arr;
}

// **********************************************************
// executing retrieved data
// **********************************************************
protected function exec() { // prepare for webexec()
	$this->ftp->connect(); parent::exec();
	$this->ftp->disconnect();
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
protected function dstName($fso, $act = false) {
	$chk = STR::contains(".cpf.mkd.", ".$act."); if (! $chk) return $fso;
	$pfx = $this->ftp->get("ftp.froot"); if (STR::begins($fso, $pfx)) return $fso;
	return FSO::join($pfx, $fso);
}

protected function verTarget() {
	$out = $this->htp->query(".", "ver");
	$out = implode(" - ", $out);
	return ($out) ? $out : "?";
}

// ***********************************************************
// overwrite file actions
// ***********************************************************
#protected function do_copy($src, $dst) { // single file op
#	if ($this->ftp->isProtected($dst)) return false;
#	return $this->ftp->remote_put($src, $dst);
#}
protected function do_copy($file) { // single file op
	if ($this->ftp->isProtected($file)) return false;

	$srv = $this->ftp->get("web.url");
	
	$crl = new curl();
	return $crl->upload("https://$srv", $file);
}

// ***********************************************************
#protected function do_mkDir($dst) { // single dir op
#	return $this->ftp->remote_mkdir($dst);
#}
protected function do_mkDir($lst) { // bulk operation
	$out = $this->htp->query($lst, "mkd");
	return intval($out);
}

// ***********************************************************
protected function do_ren($lst) { // bulk operation
	$out = $this->htp->query($lst, "ren");
	return intval($out);
}
protected function do_rmDir($lst) { // bulk operation
	$out = $this->htp->query($lst, "rmd");
	return intval($out);
}
protected function do_kill($lst) { // bulk operation
	$out = $this->htp->query($lst, "dpf");
	return intval($out);
}

// ***********************************************************
// find versions
// ***********************************************************
protected function getVersions() {
	$ver = APP::arcDir(SRV_ROOT, "ver");

	$drs = FSO::folders($ver);
	$arr = array(APP_DIR => "Current state");
	
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
} // END OF CLASS
// ***********************************************************
?>
