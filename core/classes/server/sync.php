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

incCls("server/xfer.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class sync extends tpl {
	protected $lst = array();	// list of verified destination dirs
	protected $rep = array();   // transaction report
	protected $ren = array();   // fso's without numbers
	protected $drp = array();   // dirs to drop

	protected $visOnly = true;  // exclude hidden files from sync
	protected $newProt = true;  // protect newer files
	protected $err = false;

	protected $srcPath = false;
	protected $trgPath = false;


function __construct($dev) {
	LOC::setArchive($dev);

	$this->load("modules/xfer.sync.tpl");
	$this->register();
	$this->setNewer();
}

// ***********************************************************
// set parameters
// ***********************************************************
public function setSource($dir) {
	$this->srcPath = $this->chkPath($dir);

	$this->set("source", $this->visPath($dir));
	$this->set("vsrc",   $this->getVersion($dir));
}
public function setTarget($dir) {
	$this->trgPath = $this->chkPath($dir);

	$this->set("target", $this->visPath($dir));
	$this->set("vtrg",   $this->getVersion($dir));
}

// ***********************************************************
protected function setNewer() { // protect newer files?
	$val = ENV::get("pnew", 1);
	$this->set("pnew", $val);
	$this->newProt = $val;
}

// ***********************************************************
public function setVisOnly($value) {
	$val = ($value) ? BOOL_NO : BOOL_YES;
	$this->set("what", $val);
}

// ***********************************************************
// retrieve info
// ***********************************************************
protected function srcName($fso)  {
	if (STR::begins($fso, $this->srcPath)) return $fso;
	return FSO::join($this->srcPath, $fso);
}
protected function trgName($fso, $act = false) {
	if (STR::begins($fso, $this->trgPath)) return $fso;
	return FSO::join($this->trgPath, $fso);
}

// ***********************************************************
protected function visPath($dir) {
	$out = CFG::restore($dir); if ($out != $dir) return $out;
	$arc = LOC::arcDir();

	if (STR::begins($dir, $arc)) {
		$out = STR::after($dir, "$arc/");
		return "~/cms.backup/$out";
	}
	return $dir;
}

protected function getVersion($dir) {
	if (! $dir) return "?";
	$fil = FSO::join($dir, "config/config.ini");

	$ini = new ini($fil);
	return $ini->get("app.VERSION", "?");
}

// ***********************************************************
// run jobs
// ***********************************************************
protected function run($info = "info") {
	$act = ENV::getParm("sync.act");

 // execute before display
	if ($act == 2) $this->exec();

	$this->confirm($info);

	if ($act == 1) return $this->analize();
	if ($act == 2) return $this->showStats();

	ENV::set("sync.jbs", false);
}

// **********************************************************
protected function confirm($info) {
	$this->show($info);
	$this->show();
}

// **********************************************************
protected function exec() {
TMR::punch("exec.in");

	$arr = ENV::get("sync.jbs"); if (! $arr) return false;
	$rep = array("ren" => 0, "mkd" => 0, "rmd" => 0, "cpf" => 0, "dpf" => 0);

	$arr = $this->aggregate($arr);

	foreach ($arr as $act => $lst) {
		foreach ($lst as $key => $fso) {
			$erg = $this->manage($act, $fso); if (! $erg) continue;

			$rep[$act]+= $erg;
			unset($arr[$act][$key]);
		}
		if (! VEC::get($arr, $act)) unset($arr[$act]);
	}


	ENV::set("sync.jbs", $arr);
	$this->rep = $rep;

TMR::punch("exec.done");
}

// **********************************************************
protected function manage($act, $fso) {
	$src = $this->srcName($fso, $act);
	$dst = $this->trgName($fso, $act);

	switch ($act) {
		case "ren": return $this->do_ren($fso);
		case "mkd": return $this->do_mkDir($dst);
		case "rmd": return $this->do_rmDir($dst);
		case "cpf": return $this->do_copy($src, $dst);
		case "dpf": return $this->do_kill($dst);
	}
	return; // do nothing !
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
	$lst = $this->getTree($this->srcPath, $this->trgPath);

	ENV::set("sync.jbs", $lst);
	$this->preView(true);
}

protected function preView($tellMe = false) {
	$arr = ENV::get("sync.jbs", false);

	if ($this->err) return MSG::now($this->err);
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
	$cap = DIC::get($cap); $out = array();

	foreach ($arr as $key => $val) {
		$out[] = "[$key] = $val";
	}
	$this->set("cap", $cap);
	$this->set("data", implode("\n", $out));

	echo $this->getSection("stats");
}

// ***********************************************************
// show results
// ***********************************************************
protected function report() {
	HTW::xtag("ftp.report"); $blk = "ren.rmd.dpf.mkd"; $out = array();

	foreach ($this->rep as $key => $val) {
		$cat = "file(s)"; if (STR::contains($blk, $key))
		$cat = "block(s)";

		$this->set("inf", DIC::getPfx("arr", $key));
		$this->set("val", $val);
		$this->set("cat", $cat);

		$out[] = $this->getSection("report.row");
	}
	$this->set("tdata", implode("\n", $out));
	echo $this->getSection("report");
}

// ***********************************************************
// file handling
// ***********************************************************
protected function getTree($src, $dst) {
	$src = $this->lclFiles($src); if (! $src) return false;
	$dst = $this->lclFiles($dst);
	$out = $this->getNewer($src, $dst);

	$out = $this->chkRename($out);
	$out = $this->chkCount($out);
	return $out;
}

// ***********************************************************
protected function lclFiles($dir) {
	$srv = new xfer($this->visOnly);
	$out = $srv->getFiles($dir);
	return $this->conv($out);
}

protected function conv($txt) {
	return STR::slice($txt);
}

protected function chkErr($arr, $inf) {
	if (count($arr) > 5) return false;
	$this->err = DIC::get("err.fetch")." ".DIC::get($inf);
	return true;
}

// ***********************************************************
protected function getNewer($src, $dst) {
	if ($this->chkErr($src, "source")) return array();
#	if ($this->chkErr($dst, "target")) return array();

	$out = $lst = $ren = array();

	foreach ($src as $itm) { // source - e.g. local files
		$inf = $this->split($itm, "s"); if (! $inf) continue; extract($inf);
		$lst[$fso] = $inf;

		$ren[$alf]["typ"] = $typs;
		$ren[$alf]["src"] = $fso;
	}
	foreach ($dst as $itm) { // destination - e.g. remote files
		$inf = $this->split($itm, "d"); if (! $inf) continue; extract($inf);

		if (  isset($lst[$fso])) $lst[$fso]+= $inf; else $lst[$fso] = $inf;
		if (! isset($ren[$alf])) continue;

		if ( $ren[$alf]["src"] == $fso) unset($ren[$alf]);
		else $ren[$alf]["dst"] =  $fso;
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
	$prp = STR::slice($fso, "|"); if (count($prp) < 3) return false;
	$old = $this->trgName($prp[2]);
	$new = $this->trgName($prp[1]);

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
	$itm = STR::slice($itm, ";"); if (count($itm) < 4) return false;
	$fso = $itm[3];

	return array(
		"fso" => $fso,
		"alf" => PRG::replace($fso, "\/\d\d\d\.", DIR_SEP),
		"typ".$pfx => $itm[0],
		"dat".$pfx => $itm[1],
		"md5".$pfx => $itm[4]
	);
}

protected function chkProps($arr) {
	$out = array(
		"fso" => "",   "alf" => "",
		"typs" => "x", "typd" => "x",
		"dats" => "",  "datd" => "",
		"md5s" => "",  "md5d" => "",
	);
	foreach ($arr as $key => $val) {
		$out[$key] = $val;
	}
	return $out;
}

protected function chkPath($dir) {
	$dir = CFG::apply($dir);
	return FSO::norm($dir);
}

// ***********************************************************
// dummies for derived classes
// ***********************************************************
protected function aggregate($arr) {
	return $arr;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
