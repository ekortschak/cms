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

	$this->setVisOnly(true);
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
	$val = (bool) $value;
	$chr = ($val) ? BOOL_NO : BOOL_YES;

	$this->visOnly = $val;
	$this->set("what", $chr);
}

// ***********************************************************
// retrieve info
// ***********************************************************
protected function srcName($fso)  {
	if (STR::begins($fso, $this->srcPath)) return $fso;
	return FSO::join($this->srcPath, $fso);
}
protected function trgName($fso) {
	if (STR::begins($fso, $this->trgPath)) return $fso;
	return FSO::join($this->trgPath, $fso);
}

// ***********************************************************
protected function visPath($dir) {
	$out = CFG::encode($dir); if ($out != $dir) return $out;
	$arc = LOC::arcDir();

	if (STR::begins($dir, $arc)) {
		$out = STR::after($dir, "$arc/");
		return FSO::join("~/cms.archive", APP_NAME, $out);
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

	switch ($act) {
		case 1: return $this->analize();
		case 2: return $this->showStats();
	}
	ENV::set("sync.jbs", false);
	return false;
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
	$arr = $this->reArrange($arr); // put "ren" first

	foreach ($arr as $act => $lst) {
		foreach ($lst as $key => $fso) {
			$res = $this->manage($act, $fso); if (! $res) continue;

			$this->rep[$act]++;
			unset($arr[$act][$key]);
		}
		if (! VEC::get($arr, $act)) unset($arr[$act]);
	}
	ENV::set("sync.jbs", $arr);

TMR::punch("exec.done");
}

// **********************************************************
protected function manage($act, $fso) {
	if ($act == "ren") return $this->do_ren($fso);

	$src = $this->srcName($fso);
	$dst = $this->trgName($fso);

	switch ($act) {
		case "mkd": return $this->do_mkDir($dst);
		case "rmd": return $this->do_rmDir($dst);
		case "cpf": return $this->do_copy($src, $dst);
		case "dpf": return $this->do_kill($dst);
	}
	return; // do nothing !
}

// **********************************************************
protected function showStats() {
	$xxx = $this->report();
	return $this->preview();
}

// ***********************************************************
// search file systems for differences
// ***********************************************************
protected function analize() {
	$lst = $this->getTree($this->srcPath, $this->trgPath);
	ENV::set("sync.jbs", $lst);

	return $this->preView(true);
}

protected function preView($tellMe = false) {
	$arr = ENV::get("sync.jbs", false);

	if ($this->err) return MSG::now($this->err);
	if (! $arr) {
		if ($tellMe) MSG::now("do.nothing");
		return true;
	}
	$this->showStat($arr, "man", "sync.protected");
	$this->showStat($arr, "nwr", "sync.newer");
	$this->showStat($arr, "ren", "sync.rename");
	$this->showStat($arr, "mkd", "sync.mkdir");
	$this->showStat($arr, "cpf", "sync.copy");
	$this->showStat($arr, "rmd", "sync.rmdir");
	$this->showStat($arr, "dpf", "sync.kill");
	return false	;
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
	HTW::xtag("ftp.report"); $out = array();

	foreach ($this->rep as $key => $val) {
		$this->set("inf", DIC::getPfx("arr", $key));
		$this->set("cat", $this->getCat($key));
		$this->set("val", $val);

		$out[] = $this->getSection("report.row");
	}
	$rep = DIC::get("no.jobs"); if ($out) $rep = implode("\n", $out);

	$this->set("tdata", $rep);
	echo $this->getSection("report");
}

protected function getCat($act) {
// to be overruled by derived classes
	if (STR::ends($act, "d")) return "";
	if (STR::ends($act, "f")) return "";
	return DIC::get("items(s)");
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
	return STR::split($txt);
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

	$out = $lst = array();

	foreach ($src as $itm) { // source - e.g. local files
		$inf = $this->split($itm, "s"); if (! $inf) continue; extract($inf);
		$lst[$alf] = $inf; if ($typs == "d")
		$this->ren[$alf]["src"] = $fsos;
	}
	foreach ($dst as $itm) { // destination - e.g. remote files
		$inf = $this->split($itm, "d"); if (! $inf) continue; extract($inf);
		if (! isset($lst[$alf])) $lst[$alf] = array();
		$lst[$alf]+= $inf;

		$this->chkRen($lst[$alf]);
	}
	foreach ($lst as $fso => $prp) { // check dates
		$inf = $this->chkProps($prp); extract($inf);

		if ($typs === "f")
		if ($md5s === $md5d) continue;

		$act = $this->getAction($typs.$typd, $dats >= $datd);
		$act = $this->chkAction($act, $fso);

		switch ($act) {
			case "mkd": case"cpf": $out[$act][] = $fsos; break;
			case "rmd": case"dpf": $out[$act][] = $fsod; break;
			case "nwr":            $out[$act][] = $fsos; break;
		}
	}
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

protected function chkAction($act, $fso) { // dropping fso
	if (STR::misses(".rmd.dpf.", $act)) return $act;
	if (STR::begins($fso, $this->drp))  return "x"; // already taken care of
	if ($act == "rmd") $this->drp[] = $fso;
	return $act;
}

// ***********************************************************
// executing modifications
// ***********************************************************
protected function do_ren($fso) {
	$prp = STR::split($fso, " => "); if (count($prp) < 2) return false;
	$old = $this->trgName($prp[0]);  if (! $old) return false;
	$new = $this->trgName($prp[1]);  if (! $new) return false;

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
protected function chkRen($inf) {
	extract($inf);
	if ( ! isset($fsos))                    return $this->dropRen($alf);
	if (basename($fsos) == basename($fsod)) return $this->dropRen($alf);
	$this->ren[$alf]["dst"] = $fsod;
}
protected function dropRen($alf) {
	unset($this->ren[$alf]);
}

protected function chkRename($arr) {
	foreach ($this->ren as $alf => $itm) {
		if (count($itm) < 2) continue; extract($itm);
		$arr["ren"][] = "$dst => $src";
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
// dummies for derived classes
// ***********************************************************
protected function aggregate($arr) {
	return $arr;
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
protected function split($itm, $pfx) {
	$itm = strip_tags(trim($itm));
	$itm = STR::split($itm, ";"); if (count($itm) < 4) return false;
	$fso = $itm[3];

	return array(
		"alf" => PRG::replace($fso, "\/(\d{1,3})\.", DIR_SEP),
		"fso".$pfx => $fso,
		"typ".$pfx => $itm[0],
		"dat".$pfx => $itm[1],
		"md5".$pfx => $itm[4]
	);
}

protected function chkProps($arr) {
	$out = array(
		"fsos" => "",  "fsod" => "",  "alf" => "",
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

protected function reArrange($arr) {
	$out = array("ren" => false);
	return array_merge($out, $arr);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
