<?php

/* ***********************************************************
// INFO
// ***********************************************************
basic class for synching
* contains common features for all derived classes
* local working and backup dirs

// ***********************************************************
// HOW TO USE
// ***********************************************************
$snc = new sync();
$snc->setDevice($dev);
$snc->setSource($src);
$snc->setDest($dest);
$snc->backup();
$snc->restore();
*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class sync extends objects {
	protected $dev = SRV_ROOT;  // storage device
	protected $src = APP_DIR;   // source
	protected $dst = "";		// destination
	protected $root = "";		// common path

	protected $lst = array();	// list of verified destination dirs
	protected $rep = array();   // transaction report
	protected $ren = array();   // fso's without numbers
	protected $drp = array();   // dirs to drop

function __construct() {
	$this->rep = array("ren" => 0, "mkd" => 0, "rmd" => 0, "cpf" => 0, "dpf" => 0);
	$this->set("head", "Sync");
	$this->set("info", false);

	$this->setOID();
	$this->setSource();
	$this->setDest();
}

// ***********************************************************
// set parameters
// ***********************************************************
public function setSource($dir = APP_DIR) {
	$this->src = FSO::norm($dir);
	$this->setOidVar("sync.src", $this->src);
}
public function setDest($dir = NV) {
	if ($dir == NV) $dir = APP::bkpDir("sync", $this->dev);
	$this->dst = FSO::norm($dir);
	$this->setOidVar("sync.dst", $this->dst);
}

// ***********************************************************
// run jobs
// ***********************************************************
// no further methods by itself

protected function run() {
	$act = ENV::getParm("sync.act");
	$arr = $this->getOidVar("sync.jbs");

	if ($act == 1) return $this->analize();
	if ($act == 2) return $this->exec();

	$this->setOidVar("sync.jbs", false);
}

// **********************************************************
protected function exec() {
	$arr = $this->getOidVar("sync.jbs"); if (! $arr) return false;
	$arr = $this->aggregate($arr);

	foreach ($arr as $act => $lst) {
		foreach ($lst as $key => $fso) {
			$erg = $this->manage($act, $fso);
			if ($erg) {
				$this->rep[$act]+= $erg;
				if ($act == "cpf") unset($arr[$act][$key]);
			}
		}
		if ($act != "cpf") unset($arr[$act]);
	}
	$this->setOidVar("sync.jbs", $arr);

	$this->report();
	$this->preview();
}

// **********************************************************
protected function manage($act, $fso) {
	$src = $this->srcName($fso, $act);
	$dst = $this->destName($fso, $act);

	switch ($act) {
		case "ren": return $this->do_ren($fso);
		case "mkd": return $this->do_mkDir($dst);
		case "rmd": return $this->do_rmDir($dst);
		case "cpf": return $this->do_copy($src, $dst);
		case "dpf": return $this->do_kill($dst);
		case "man": return; // do nothing !
	}
	echo "SyncERROR - $act";
}

// ***********************************************************
// show operative info
// ***********************************************************
protected function showInfo($head = false) {
	$tpl = new tpl();
	$tpl->read("design/templates/editor/mnuSync.tpl");

	if ($head)
	$tpl->set("head", $head);
	$tpl->set("title", $this->get("title"));
	$tpl->set("source", $this->src);
	$tpl->set("dest", $this->dst); if ($this->get("info"))
	$tpl->show("info");
	$tpl->show();
}

// ***********************************************************
// search file systems for differences
// ***********************************************************
protected function analize() {
	$lst = $this->getTree($this->src, $this->dst);
	$xxx = $this->setOidVar("sync.jbs", $lst);
	$xxx = $this->preView(true);
}

protected function preView($tellMe = false) {
	$arr = $this->getOidVar("sync.jbs");
	if (! $arr) {
		if ($tellMe) return MSG::now("do.nothing");
		return;
	}
	$this->showStat($arr, "man", "protected");
	$this->showStat($arr, "ren", "Rename");
	$this->showStat($arr, "mkd", "MkDir");
	$this->showStat($arr, "cpf", "Copy");
	$this->showStat($arr, "rmd", "RmDir");
	$this->showStat($arr, "dpf", "Kill");
}

protected function showStat($arr, $act, $cap) {
	$arr = VEC::get($arr, $act); if (! $arr) return;
	$cap = DIC::get($cap);
	DBG::list($arr, $cap);
}

// ***********************************************************
// show results
// ***********************************************************
protected function report() {
	HTM::tag("ftp.report"); $blk = "ren.rmd.dpf";
	$out = "<table>\n";

	foreach ($this->rep as $key => $val) {
		$inf = DIC::check("arr", $key);
		$cat = "file(s)";  if (STR::contains($blk, $key))
		$cat = "block(s)"; if ($key == "mkd")
		$cat = "dir(s)";

		$out.= "<tr><td width=200>$inf</td><td align='right'>$val</td><td><hint>$cat</hint></td><tr>\n";
	}
	$out.= "</table>\n";
	HTM::cap($out, "p");
}

// ***********************************************************
// file handling
// ***********************************************************
protected function getTree($dir, $dst) {
	$src = $this->FSlocal($dir); if (! $src) return false;
	$dst = $this->FSlocal($dst);
	$out = $this->getNewer($src, $dst);

	$out = $this->chkRename($out);
	$out = $this->chkCount($out);
	return $out;
}

// ***********************************************************
protected function FSlocal($dir) {
	incCls("server/fileServer.php");

	$srv = new srvX();
	$out = $srv->getFiles($dir); if (! $out) return array();
	$fst = current($out);

	if (STR::begins($fst, "Error")) {
		MSG::now($fst);
	}
	return $out;
}

// ***********************************************************
protected function getNewer($src, $dst) {
	if (count($src) < 5) {
		return MSG::now("err.fetch");
	}
	$out = $lst = array();
	$roots = $this->getRoot($src);
	$rootd = $this->getRoot($dst);

	foreach ($src as $itm) { // source - e.g. local files
		$tmp = $this->split($itm); if (! $tmp) continue; extract($tmp);
		$fso = STR::after($fso, $roots); if (! $fso) continue;

		$lst[$fso]["typs"] = $type;
		$lst[$fso]["dats"] = $date;
		$lst[$fso]["md5s"] = $md5;

		$alf = $this->getAlpha($fso);
		$this->ren[$alf]["typ"] = $type;
		$this->ren[$alf]["src"] = $fso;
	}
	foreach ($dst as $itm) { // destination - e.g. remote files
		$tmp = $this->split($itm); if (! $tmp) continue; extract($tmp);
		$fso = STR::after($fso, $rootd); if (! $fso) continue;

		$lst[$fso]["typd"] = $type;
		$lst[$fso]["datd"] = $date;
		$lst[$fso]["md5d"] = $md5;

		$alf = $this->getAlpha($fso);
		$this->ren[$alf]["dst"] = $fso;
	}
	foreach ($lst as $fso => $prp) { // check dates
		$typs = VEC::get($prp, "typs", "x"); if ($typs == "h") continue;
		$md5s = VEC::get($prp, "md5s", 0);
		$dats = VEC::get($prp, "dats", 0);

		$typd = VEC::get($prp, "typd", "x"); if ($typd == "h") continue;
		$md5d = VEC::get($prp, "md5d", 0);
		$datd = VEC::get($prp, "datd", 0);

#		if ($typs == "f") // check if files are identical
		if ($md5s === $md5d) continue;

		$act = $this->getAction($typs.$typd, $dats, $datd);
		$act = $this->chkDrop($act, $fso);

		if ($act == "x") continue;

		$out[$act][] = $fso;
	}
	return $out;
}

// ***********************************************************
protected function getAction($mds, $dats, $datd) {
	if ($mds == "dx") return "mkd"; // mkdir
	if ($mds == "xd") return "rmd"; // rmdir
	if ($mds == "fx") return "cpf"; // copy file
	if ($mds == "xf") return "dpf"; // drop file

	if ($mds == "ff") {
		if ($datd < $dats) return "cpf"; // update
	}
	return "x"; // ignore
}

protected function getAlpha($fso) {
	$out = PRG::replace($fso, "\/\d\d\d\.", "\/");
	return $out;
}

// ***********************************************************
protected function do_ren($fso) {
	$prp = explode("|", $fso); if (count($prp) < 3) return false;
	return (bool) FSO::rename($prp[1], $prp[2]);
}

protected function do_mkDir($dst) {
	return (bool) FSO::force($dst);
}
protected function do_rmDir($dst) {
	return (bool) FSO::rmDir($dst);
}
protected function do_kill($dst)  {
	return (bool) FSO::kill($dst);
}
protected function do_copy($src, $dst) {
	return (bool) FSO::copy($src, $dst);
}

// **********************************************************
// check for shortcuts renaming rather than copy and delete
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

// ***********************************************************
protected function chkCount($arr) {
	foreach ($arr as $key => $itm) {
		if (! is_array($itm)) continue;
		if (! $itm) unset($arr[$key]);
	}
	return $arr;
}

protected function chkDrop($act, $fso) {
	if (STR::misses(".rmd.dpf.", $act)) return $act;
	if (STR::begins($fso, $this->drp))  return "x";
	if ($act == "rmd") $this->drp[] = $fso;
	return $act;
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
protected function getRoot($arr) {
	$out = VEC::get($arr, "root"); if (! $out)
	$out = current($arr);
	return rtrim($out, DIR_SEP).DIR_SEP;
}

protected function split($itm) {
	$itm = strip_tags(trim($itm));
	$itm = explode(";", $itm); if (count($itm) < 4) return false;

	return array(
		"type" => $itm[0],
		"fso"  => $itm[2],
		"date" => $itm[1],
		"md5"  => $itm[3]
	);
}

// ***********************************************************
// dummies for derived classes
// ***********************************************************
protected function srcName($fso, $act = false)  { return $fso; }
protected function destName($fso, $act = false) { return $fso; }

protected function aggregate($arr) { return $arr; }

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
