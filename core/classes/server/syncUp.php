<?php
/* ***********************************************************
// INFO
// ***********************************************************
Designed to sync local project to server ...
* settings: config/ftp.ini

// ***********************************************************
// HOW TO USE
// ***********************************************************
$pub = new syncUp();
$pub->read("ftp.ini");
$pub->setSource(APP_DIR);
$pub->publish();
*/

incCls("server/sync.php");
incCls("server/http.php");
incCls("server/ftp.php");
incCls("server/SSL.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class syncUp extends sync {
	protected $htp;	// http object
	protected $ftp;	// ftp object

	protected $tpl = "editor/xfer.syncUp.tpl";

function __construct() {
	parent::__construct();

	$this->set("info", true);

	$this->ftp = new ftp();
	$this->read();
	$this->setSource(APP_DIR);
}

// ***********************************************************
public function read($ini = false) {
	$fil = APP::relPath($ini);
	$this->set("inifile", $fil);

	$this->ftp->read($ini);
	$this->getDest();
}

protected function getDest() {
	$dst = $this->ftp->get("web.url", "???");
	$this->setDest($dst);

	$this->htp = new http($this->dst);
}

// ***********************************************************
// run jobs
// ***********************************************************
public function publish() {
	if (! $this->ftp->test()) return;

	$this->setTitle("sync.up");
	$this->showInfo();
	$this->run();
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
	$out = $this->htp->query(".");
	return $out;
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
// debugging server response
// ***********************************************************
public function debug($dst) {
	if (! $dst) return;

	foreach ($arr as $act) {
		$lst = VEC::get($dst, $act); if (! $lst) continue;

		foreach ($lst as $itm) {
			$this->getUrl($act, $itm);
		}
	}
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
protected function destName($fso, $act = false) {
	$chk = STR::contains(".cpf.mkd.", ".$act."); if (! $chk) return $fso;
	$pfx = $this->ftp->get("ftp.froot"); if (STR::begins($fso, $pfx)) return $fso;
	return FSO::join($pfx, $fso);
}

// ***********************************************************
// overwrite file actions
// ***********************************************************
protected function do_copy($src, $dst) { // single file op
	if ($this->ftp->isProtected($dst)) return false;
	return $this->ftp->remote_put($src, $dst);
}

// ***********************************************************
protected function do_mkDir($dst) { // single dir op
	return $this->ftp->remote_mkdir($dst);
}
#protected function do_mkDir($arr) { // bulk operation
#	$out = $this->htp->query($arr, "mkd");
#	return intval($out);
#}

// ***********************************************************
protected function do_ren($arr) { // bulk operation
	$out = $this->htp->query($arr, "ren");
	return intval($out);
}
protected function do_rmDir($arr) { // bulk operation
	$out = $this->htp->query($arr, "rmd");
	return intval($out);
}
protected function do_kill($arr) { // bulk operation
	$out = $this->htp->query($arr, "dpf");
	return intval($out);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
