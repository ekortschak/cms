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

$pub = new syncDown();
$pub->upgrade();

*/

incCls("input/confirm.php");
incCls("server/sync.php");
incCls("server/http.php");
incCls("server/ftp.php");
incCls("server/SSL.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class syncDown extends sync {
	protected $htp;	// http object
	protected $ftp;	// ftp object
	protected $dbg = 0;

function __construct() {
	parent::__construct();

	$this->set("info", true);

	$this->ftp = new ftp();
	$this->read();
}

// ***********************************************************
public function read($ini = false) {
	$this->ftp->read($ini);

	$src = $this->ftp->get("web.url", "???");
	$this->setSource($src);

	$this->htp = new http($this->src);
}

// ***********************************************************
// set parameters
// ***********************************************************
public function setSource($dir = ".") {
	$this->src = FSO::norm($dir);
	ENV::set("sync.src", $this->src);
}
public function setDest($dir = APP_DIR) {
	$this->dst = FSO::norm($dir);
	$xxx = ENV::set("sync.dst", $this->dst);
}

//// ***********************************************************
// run jobs
// ***********************************************************
public function upgrade() {
	if (! $this->ftp->test()) return;

	$this->setTitle("sync.down");
	$this->showInfo();
	$this->run();
}

// **********************************************************
// retrieving data for action
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
// pass through methods
// ***********************************************************
protected function FSremote() {
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
// auxilliary methods
// ***********************************************************
protected function srcName($fso, $act = false) {
	$pfx = $this->ftp->get("ftp.froot"); if (STR::begins($fso, $pfx)) return $fso;
	return FSO::join($pfx, $fso);
}

// ***********************************************************
// overwrite file actions
// ***********************************************************
protected function do_copy($src, $dst) { // single file op
	if ($this->ftp->isProtected($dst)) return false;
	return $this->ftp->save($src, $dst);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
