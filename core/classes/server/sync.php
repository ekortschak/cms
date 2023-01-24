<?php

/* ***********************************************************
// INFO
// ***********************************************************
basic class for synching
* contains common features for all derived classes
* local working and backup dirs

DOES NOT WORK BY ITSELF!
* use derived classes 

// ***********************************************************
// HOW TO USE
// ***********************************************************
$snc = new sync();
$snc->setDevice($dev);
$snc->setSource($src);
$snc->setTarget($dest);

for execution see derived classes
*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class sync extends tpl {
	protected $dev = SRV_ROOT;  // storage device
	protected $root = "";		// common path

	protected $lst = array();	// list of verified destination dirs
	protected $rep = array();   // transaction report
	protected $ren = array();   // fso's without numbers
	protected $drp = array();   // dirs to drop

	protected $visOnly = true;  // exclude hidden files from sync
	protected $newProt = true;  // protect newer files
	protected $error = false;

function __construct() {
	$this->rep = array("ren" => 0, "mkd" => 0, "rmd" => 0, "cpf" => 0, "dpf" => 0);

	$this->load("modules/xfer.sync.tpl");

	$this->register();
	$this->setSource(APP_DIR);
	$this->setTarget(NV);
	$this->setNewer();
}

// ***********************************************************
// set parameters
// ***********************************************************
public function setSource($dir) {
	return $this->set("source", FSO::norm($dir));
}
public function setTarget($dir) {
	if ($dir == NV) $dir = APP::arcDir($this->dev, "sync");
	return $this->set("target", FSO::norm($dir));
}

protected function setNewer() {
	$val = ENV::get("pnew", 1);
	$this->set("pnew", $val);
	$this->newProt = $val;
}

// ***********************************************************
protected function setTitle($title) {
	$tit = DIC::get($title);
	$this->set("title", $tit);
}

public function setVisOnly($value) {
	$val = ($value) ? BOOL_NO : BOOL_YES;
	$this->set("what", $val);
}

// ***********************************************************
// retrieve info
// ***********************************************************
protected function verSource() {
	$dir = $this->get("source");
	return $this->getVersion($dir);
}

protected function verTarget() {
	$dir = $this->get("target");
	return $this->getVersion($dir);
}

protected function getVersion($dir) {
	$fil = FSO::join($dir, "config/config.ini");

	$ini = new ini($fil);
	return $ini->get("app.VERSION", "?"); 
}

// ***********************************************************
// run jobs
// ***********************************************************
protected function run($info = "info") {
	$act = ENV::getParm("sync.act");
	
	if ($act == 2) $this->exec();

	$this->set("vsrc", $this->verSource());
	$this->set("vdst", $this->verTarget());

	$this->show($info); if (! $this->isGood()) return;
	$this->show();
	
	if ($act == 1) return $this->analize();
	if ($act == 2) return $this->showStats();

	ENV::set("sync.jbs", false);
}

// **********************************************************
protected function exec() {
	$arr = ENV::get("sync.jbs"); if (! $arr) return false;
	$arr = $this->aggregate($arr);

	foreach ($arr as $act => $lst) {
		if ($act == "nwr") continue;
		
		foreach ($lst as $key => $fso) {
			$erg = $this->manage($act, $fso);
			if ($erg) {
				$this->rep[$act]+= $erg;
				if ($act == "cpf") unset($arr[$act][$key]);
			}
		}
		if ($act != "cpf") unset($arr[$act]);
	}
	ENV::set("sync.jbs", $arr);
}

// **********************************************************
protected function manage($act, $fso) {
	$src = $this->srcName($fso, $act);
	$dst = $this->dstName($fso, $act);

	switch ($act) {
		case "ren": return $this->do_ren($fso);
		case "mkd": return $this->do_mkDir($dst);
		case "rmd": return $this->do_rmDir($dst);
		case "cpf": return $this->do_copy($src, $dst);
		case "dpf": return $this->do_kill($dst);
		case "man": return; // do nothing !
	}
	ERR::msg("sync.error", $act);
}

// **********************************************************
protected function showStats() {
	$this->report();
	$this->preview();
}

// ***********************************************************
// search file systems for differences
// ***********************************************************
protected function analize() {
	$src = $this->get("source");
	$dst = $this->get("target");
	$lst = $this->getTree($src, $dst);

	ENV::set("sync.jbs", $lst);
	$this->preView(true);
}

protected function preView($tellMe = false) {
	$arr = ENV::get("sync.jbs", NV);

	if ($this->error == "nocon") return MSG::now("no.connection");
	if (! $arr) {
		if (! $tellMe) return;
		return MSG::now("do.nothing");
	}

	$this->showStat($arr, "man", "sync.protected");
	$this->showStat($arr, "nwr", "sync.newer");
	$this->showStat($arr, "ren", "sync.rename");
	$this->showStat($arr, "mkd", "sync.mkdir");
	$this->showStat($arr, "cpf", "sync.copy");
	$this->showStat($arr, "rmd", "sync.rmdir");
	$this->showStat($arr, "dpf", "sync.kill");
}

protected function showStat($arr, $act, $cap) {
	$arr = VEC::get($arr, $act); if (! $arr) return;
	$cap = DIC::get($cap);

	HTW::tag($cap, "h5");
	echo "<div class='pre'>";

	foreach ($arr as $key => $val) {
		echo "[$key] = $val\n";
	}
	echo "</div>";
}

// ***********************************************************
// show results
// ***********************************************************
protected function report() {
	HTW::xtag("ftp.report"); $blk = "ren.rmd.dpf";
	$out = "<table>\n";

	foreach ($this->rep as $key => $val) {
		$inf = DIC::getPfx("arr", $key);
		$cat = "file(s)";  if (STR::contains($blk, $key))
		$cat = "block(s)"; if ($key == "mkd")
		$cat = "dir(s)";

		$out.= "<tr><td width=200>$inf</td><td align='right'>$val</td><td><hint>$cat</hint></td><tr>\n";
	}
	$out.= "</table>\n";
	HTW::tag($out, "p");
}

// ***********************************************************
// file handling
// ***********************************************************
protected function getTree($src, $dst) {
	$src = $this->FSlocal($src); if (! $src) return false;
	$dst = $this->FSlocal($dst);
	$out = $this->getNewer($src, $dst);

	$out = $this->chkRename($out);
	$out = $this->chkCount($out);
	return $out;
}

// ***********************************************************
protected function FSlocal($dir) {
	incCls("server/fileServer.php");

	$srv = new fileServer($this->visOnly);
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
	$out = $lst = $ren = array();

	foreach ($src as $itm) { // source - e.g. local files
		$inf = $this->split($itm, "s"); if (! $inf) continue; extract($inf);
		$lst[$fso] = $inf;

		$ren[$alf]["typ"] = $typd;
		$ren[$alf]["src"] = $fso;
	}

	foreach ($dst as $itm) { // destination - e.g. remote files
		$inf = $this->split($itm, "d"); if (! $inf) continue; extract($inf);
		
		if (  isset($lst[$fso])) $lst[$fso]+= $inf; else $lst[$fso] = $inf;
		if (! isset($ren[$alf])) continue;

		if ( $ren[$alf]["src"] == $fso) unset($ren[$alf]);
		else $ren[$alf]["dst"] = $fso;
	}

	foreach ($lst as $fso => $prp) { // check dates
		$inf = $this->chkProps($prp); extract($inf); 
		
		if ($md5s === $md5d) continue;

		$act = $this->getAction($typs.$typd, $dats >= $datd);
		$act = $this->chkAction($act, $fso);

		if ($act == "x") continue;

		$out[$act][] = $fso;
	}
	$this->ren = $ren;
	return $out;
}

// ***********************************************************
// determining action
// ***********************************************************
protected function getAction($mds, $newer) {
	if ($mds == "dx") return "mkd"; // mkdir
	if ($mds == "xd") return "rmd"; // rmdir
	if ($mds == "fx") return "cpf"; // copy file
	if ($mds == "xf") return "dpf"; // drop file

	if ($mds == "ff") {
		if ($newer) return "cpf"; // update
		if ($this->newProt) return "nwr"; // protect newer files
		return "cpf";
	}
	return "x"; // ignore
}

protected function chkAction($act, $fso) {
	if (STR::misses(".rmd.dpf.", $act)) return $act;
	if (STR::begins($fso, $this->drp))  return "x";
	if ($act == "rmd") $this->drp[] = $fso;
	return $act;
}

// ***********************************************************
// executing modifications
// ***********************************************************
protected function do_ren($fso) {
	$prp = explode("|", $fso); if (count($prp) < 3) return false;
	$old = $this->dstName($prp[2]);
	$new = $this->dstName($prp[1]);

	return (bool) FSO::rename($old, $new);
}

protected function do_mkDir($dst) {
	return (bool) FSO::force($dst);
}
protected function do_rmDir($dst) {
	if ($dst == APP_DIR) return false;
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
		if ($typ != "d")     continue;
		if ($src == $dst)    continue;

		if (isset($arr["mkd"])) $arr["mkd"] = VEC::purge($arr["mkd"], $src); // src = new name
		if (isset($arr["cpf"])) $arr["cpf"] = VEC::purge($arr["cpf"], $src);
		if (isset($arr["rmd"])) $arr["rmd"] = VEC::purge($arr["rmd"], $dst); // dst = old name
		if (isset($arr["dpf"])) $arr["dpf"] = VEC::purge($arr["dpf"], $dst);

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

// ***********************************************************
// auxilliary methods
// ***********************************************************
protected function split($itm, $pfx) {
	$itm = strip_tags(trim($itm));
	$itm = explode(";", $itm); if (count($itm) < 4) return false;
	$fso = $itm[2];

	return array(
		"fso" => $fso,
		"alf" => PRG::replace($fso, "\/\d\d\d\.", "\/"),
		"typ".$pfx => $itm[0],
		"dat".$pfx => $itm[1],
		"md5".$pfx => $itm[3]
	);
}

protected function chkProps($arr) {
	$out = array(
		"fso" => "",   "alf" => "",
		"typs" => "x", "typd" => "x",
		"dats" => "",  "datd" => "",
		"md5s" => "",  "mdtd" => "",
	);
	foreach ($arr as $key => $val) {
		$out[$key] = $val;
	}
	return $out;
}

// ***********************************************************
// dummies for derived classes
// ***********************************************************
protected function srcName($fso, $act = false)  {
	$src = $this->get("source");
	if (STR::begins($fso, $src)) return $fso;
	return FSO::join($src, $fso);
}
protected function dstName($fso, $act = false) {
	$dst = $this->get("target");
	if (STR::begins($fso, $dst)) return $fso;
	return FSO::join($dst, $fso);
}

protected function aggregate($arr) {
	return $arr; 
}

protected function isGood() {
	return true;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
