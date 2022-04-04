<?php
/* ***********************************************************
// INFO
// ***********************************************************
used for uploading files to server via ftp

// ***********************************************************
// HOW TO USE
// ***********************************************************
$pub = new syncUp();
$pub->xfer($source, $destination);
*/

incCls("input/confirm.php");
incCls("server/sync.php");
incCls("server/ftp.php");
incCls("server/SSL.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class syncUp extends sync {
	protected $ftp;	// ftp object
	protected $dbg = 0;

function __construct() {
	parent::__construct();

	$this->ftp = new ftp();

	$this->src = APP_DIR;
	$this->dst = ".";
}

public function read($ini) {
	$this->ftp->read($ini);
}

// ***********************************************************
// acting
// ***********************************************************
public function xfer($src = false, $dst = false) {
	if (! $this->ftp->test()) return;

	if ($src) $this->src = FSO::norm($src, true);
	if ($dst) $this->dst = FSO::norm($dst, true);

	switch ($this->ask()) {
		case "done": $this->doExec(); break;
		default:     $this->doView();
	}
}

protected function ask() {
	$url = $this->ftp->get("web.url");
	$msg = DIC::get("data.xfer");
	$frm = DIC::get("from");

	$cnf = new confirm();
	$sec = "main"; if ($cnf->checked())
	$sec = "check";

	$cnf->head($msg);
	$cnf->add("$frm $this->src");
	$cnf->add("&rarr; <a href='http://$url' target='_blank'>$url</a>");
	$cnf->show();

	return $cnf->act();
}

// ***********************************************************
// synching to server (= upload)
// ***********************************************************
protected function doView() { // upload newer files
	$this->ftp->connect();

	$arr = $this->getTree($this->src, $this->dst); if (! $arr) return MSG::now("do.nothing");
	$lst = $this->aggregate($arr);

	ENV::set("ftp.pend", $lst);

	$this->showStat($arr, "man", "protected");
	$this->showStat($arr, "ren", "Rename");
	$this->showStat($arr, "mkd", "MkDir");
	$this->showStat($arr, "cpf", "Copy");
	$this->showStat($arr, "rmd", "RmDir");
	$this->showStat($arr, "dpf", "Kill");

	$this->ftp->disconnect();
	$this->debug($lst);
	return true;
}

protected function aggregate($data) { // prepare for webexec()
	$out = array();

	foreach ($data as $act => $lst) {
		if (STR::contains(".mkd.cpf.", $act)) { // no bulk operations
			$out[$act] = $lst;
			continue;
		}
		$arr = array(); $str = ""; $idx = 0;

		foreach ($lst as $fso) {
			if (strlen("$str;$fso") < 2000) $str.= "$fso;";
			else {
				$str = "$fso;";
				$idx++;
			}
			$arr[$idx] = trim($str);
		}
		if ($arr) $out[$act] = $arr;
	}
	return $out;
}

// **********************************************************
// retrieving data for action
// **********************************************************
protected function getTree($src, $dst) {
	$src = $this->getList($src); if (! $src) return false; // local files
	$dst = $this->webList($dst); if (! $dst) return false; // remote
	$out = $this->getNewer($src, $dst);
	$out = $this->chkProtect($out);
	$out = $this->chkRename($out);
	$out = $this->chkCount($out);
	return $out;
}

protected function webList($dir) {
	$cmd = $this->getUrl("get", $dir);
	return $this->webExec($cmd);
}

protected function getUrl($act, $fso) {
	$srv = $this->ftp->get("web.url"); if (! $srv) return false;
	$tim = date("YmdGis"); if (is_file($fso))
	$tim = filemtime($fso);
	$prm = "w:=$act &f:=$fso &t:=$tim";

	$md5 = SSL::md5($fso);
	$prm = SSL::encrypt($prm." &c:=$md5");
	$url = "https://$srv/x.sync.php?p=$prm";

	if ($this->dbg) {
#		echo "<p>$prm &c:=$md5</p>";
		echo "<p><a href='$url&d=1' target='dbg'>Debug Server Response for $act</a></p>";
	}
	return $url;
}

// **********************************************************
// check for protected files
// **********************************************************
protected function chkProtect($arr) {
	foreach ($arr as $act => $itm) {
		foreach ($itm as $fso) {
			if (! $this->isProtected($fso)) continue;
			$arr[$act] = VEC::drop($arr[$act], $fso);
			$arr["man"][] = $fso;
		}
	}
	return $arr;
}

protected function isProtected($fso) {
	return $this->ftp->isProtected($fso);
}

// **********************************************************
// check for renaming rather than copy and delete
// **********************************************************
protected function chkRename($arr) {
	foreach ($this->ren as $itm) {
		if (count($itm) < 3) continue; extract($itm);
		if ($src == $dst)    continue;

		if ($typ == "d") {
			$arr["mkd"] = VEC::purge($arr["mkd"], $src);
			$arr["rmd"] = VEC::purge($arr["rmd"], $dst);
		}
		else {
			$arr["cpf"] = VEC::drop($arr["cpf"], $src);
			$arr["dpf"] = VEC::drop($arr["dpf"], $dst);
		}
		$arr["ren"][] = "$typ|$src|$dst";
	}
	return $arr;
}

// **********************************************************
// executing retrieved data
// **********************************************************
protected function doExec() { // prepare for webexec()
	$arr = ENV::get("ftp.pend");
	$xxx = ENV::set("ftp.pend", false); if (! $arr) return;

	$this->ftp->connect();

	foreach ($arr as $act => $lst) {
		foreach ($lst as $fso) {
			if (STR::contains($fso, "~")) continue;
			$this->manage($act, $fso);
		}
	}
	$this->ftp->disconnect();
	$this->report("ftp.report");
}

// ***********************************************************
// overwrite file actions
// ***********************************************************
protected function mkDir($dst) { // single dir op
	$pfx = $this->ftp->get("ftp.froot");
	$dst = FSO::join($pfx, $dst);
	return $this->ftp->remote_mkdir($dst);
}

protected function copy($src, $dst) { // single file op
	if ($this->isProtected($src)) return false;

	$pfx = $this->ftp->get("ftp.froot");
	$dst = FSO::join($pfx, $dst);
	return $this->ftp->remote_put($src, $dst);
}

// ***********************************************************
protected function fsRen($arr) { // bulk operation
	$cmd = $this->getUrl("ren", $arr);
	$out = $this->webExec($cmd);
	return intval($out);
}
#protected function mkDir($arr) { // bulk operation
#	$cmd = $this->getUrl("mkd", $arr);
#	$out = $this->webExec($cmd);
#	return intval($out);
#}
protected function rmDir($arr) { // bulk operation
	$cmd = $this->getUrl("rmd", $arr);
	$out = $this->webExec($cmd);
	return intval($out);
}
protected function kill($arr) { // bulk operation
	$cmd = $this->getUrl("dpf", $arr);
	$out = $this->webExec($cmd);
	return intval($out);
}

// ***********************************************************
private function webExec($cmd) {
	$ssl = array( // cheating on ssl
		"ssl" => array(
			"verify_peer" => false,
			"verify_peer_name" => false
		)
	);
 // get data from server
	$out = file($cmd, false, stream_context_create($ssl));

	foreach ($out as $key => $val) {
		if (STR::begins($val, "ERROR")) {
			MSG::now($val);
			unset($out[$key]);
			continue;
		}
		$val = utf8_decode($val);
		$val = STR::replace($val, "?", ""); // TODO: why?
		$out[$key] = trim($val);
	}
	return $out;
}

// ***********************************************************
// debugging server response
// ***********************************************************
protected function showStat($arr, $act, $cap) {
	$arr = VEC::get($arr, $act); if (! $arr) return;
	$cap = DIC::get($cap);
	DBG::list($arr, $cap);
}

public function debug($dst) {
	if (! $this->dbg) return; $arr = array("ren", "mkd", "rmd", "dpf");
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
protected function srcName($fso) {
	if (STR::begins($fso, $this->src)) return $fso;
	return FSO::join($this->src, $fso);
}
protected function destName($fso) {
	if (STR::begins($fso, $this->dst)) return $fso;
	return FSO::join($this->dst, $fso);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
