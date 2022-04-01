<?php

/* ***********************************************************
// INFO
// ***********************************************************
used for synching
* local working and backup dirs

// ***********************************************************
// HOW TO USE
// ***********************************************************
$snc = new sync($dest);
$snc->sync($src);
*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class sync extends objects {
	protected $src = "";        // source
	protected $dst = "";		// destination
	protected $root = "";		// common path

	protected $lst = array();	// list of verified destination dirs
	protected $rep = array();   // transaction report
	protected $ren = array();   // fso's without numbers
	protected $drp = array();   // dirs to drop

function __construct() {
	$this->rep = array("ren" => 0, "mkd" => 0, "rmd" => 0, "cpf" => 0, "dpf" => 0);
}

// ***********************************************************
// synchronize file systems (mirror)
// ***********************************************************
public function sync($src, $dest) { // sync data to backup directory
	$this->exec($src, $dest);
	$this->report("Sync");
}
public function syncBack($src, $dest) { // restore backup to data directory
	$this->exec($src, $dest);
	$this->report("SyncBack");
}

// **********************************************************
protected function exec($src, $dst) {
	$this->src = FSO::norm($src, true);
	$this->dst = FSO::norm($dst, true);

	$arr = $this->getTree($src, $dst); if (! $arr) return 0;

	foreach ($arr as $act => $lst) {
		foreach ($lst as $fso) {
			$this->manage($act, $fso);
		}
	}
}

protected function manage($act, $fso) {
	$src = $this->srcName($fso);
	$dst = $this->destName($fso);

	switch ($act) {
		case "ren": $this->rep[$act]+= $this->fsRen($fso);      return;
		case "mkd": $this->rep[$act]+= $this->mkDir($dst);      return;
		case "rmd": $this->rep[$act]+= $this->rmDir($dst);      return;
		case "cpf": $this->rep[$act]+= $this->copy($src, $dst); return;
		case "dpf": $this->rep[$act]+= $this->kill($dst);       return;
		case "man": return; // do nothing !
	}
	echo "SyncERROR - $act";
}

// ***********************************************************
// file handling
// ***********************************************************
protected function getTree($dir, $dst) {
	$dst = $this->getList($dst);
	$src = $this->getList($dir); if (! $src) return false;
	$out = $this->getNewer($src, $dst);
	$out = $this->chkCount($out);
	return $out;
}

// ***********************************************************
protected function getList($dir) {
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

#dbg(count($src)."/".count($dst), "Files found on src/dst");

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

		if ($typs == "f") // check if files are identical
		if ($md5s === $md5d) continue;

		$act = $this->getAction($typs.$typd, $dats, $datd);
		$act = $this->chkDrop($act, $fso);

		if ($act == "x") continue;

		$out[$act][] = $fso;
	}
	return $out;
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
protected function copy($src, $dst) {
	return (bool) FSO::copy($src, $dst);
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
protected function report($head) {
	HTM::tag($head); $blk = "ren.rmd.dpf";

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
protected function srcName($fso) {
	return $fso;
}
protected function destName($fso) {
	return $fso;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
