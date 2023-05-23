<?php
/* ***********************************************************
// INFO
// ***********************************************************
turns templates as ini files

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("files/ini.php");

$ini = new ini($ini_file);
$ini->readPath($ini_dir);
$ini->read($another_ini);

*/

incCls("files/code.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class ini extends objects {
	protected $silent = true;
	protected $sealed = false;

	protected $sec = array();
	protected $typ = array();
	protected $vrs = array();

	protected $dir = "";
	protected $file = "";
	protected $fname = "page.ini";


function __construct($fso) {
	$this->read($fso);
}

function reset() {
	$this->sec = $this->typ = $this->vrs = $this->vls = array();
	$this->dir = $this->file;
}

// ***********************************************************
// handling vars
// ***********************************************************
public function getVars() {
	return $this->vrs;
}

public function getValues($sec = "") {
	if ($sec) $sec = $this->langSec($sec);
	if ($sec) if (! STR::ends($sec, ".")) $sec.= ".";
	return parent::getValues($sec);
}

// ***********************************************************
// handling sections
// ***********************************************************
public function getSecs($filter = true) {
	$arr = $this->sec; $out = array();
	$ign = STR::toArray("dic,include,register");

	foreach ($this->sec as $sec => $val) {
		if ($filter) if (STR::begins($sec, $ign)) continue;
		$out[$sec] = $sec;
	}
	return $out;
}

// ***********************************************************
public function setSec($sec, $data) {
	$this->sec[$sec] = $data;
}

public function getSec($sec) {
	$sec = $this->findSec($sec); if (! $sec) return "";
	return VEC::get($this->sec, $sec);
}

public function getSecType($sec) {
	return VEC::get($this->typ, $sec, "input");
}

// ***********************************************************
public function findSec($sec, $default = false) {
	foreach ($this->sec as $key => $val) {
		if (STR::begins($key, $sec)) return $key;
	}
	if ($default) return $default;
	return $sec;
}

// ***********************************************************
// handling properties
// ***********************************************************
public function getUID() {
 // TODO: verify uniqueness
	$uid = $this->get("props.uid");       if (! $this->isDefault($uid)) return $uid;
	$tit = $this->get(GEN_LANG.".title"); if (! $tit) $tit = "GET_TITLE";

	if ($tit != "GET_TITLE") {
		$arr = explode(" ", $tit); $out = "";

		foreach ($arr as $itm) {
			$out.= ucFirst($itm);
		}
		if ($out) return $out;
	}
	return $this->getDir();
}

public function getDir() {
	$dir = basename($this->dir);
	return PRG::clrDigits($dir);
}

public function getFile() {
	return $this->file;
}

// ***********************************************************
public function getTitle($lng = CUR_LANG) {
	$tit = $this->langProp("title");
	$out = $this->scrTitle($tit); if ($out) return $out;
	$out = $this->chkTitle($tit); if ($out) return $out;
	$out = $this->getUID();
	return ucfirst($out);
}

private function chkTitle($txt) {
	if ($txt == "GET_TITLE") return "";
	return $txt;
}

private function scrTitle($txt) {
	$scr = STR::after($txt, "script:"); if (! $scr) return false;
	$scr = FSO::join($this->dir, $scr);
	$out = APP::gcFile($scr); if ($out) return $out;
	return false;
}

// ***********************************************************
public function getHead($lng = CUR_LANG) {
	$out = $this->lng("head");
	if ($out == "GET_HEAD") $out = "";
	if ($out) return $out;
	return $this->getTitle($lng);
}

// ***********************************************************
public function getType($default = "inc") {
	$out = $this->get("props.typ", $default);
	return STR::left($out, 3);
}

// ***********************************************************
// reading ini files
// ***********************************************************
public function read($file) {
	$fil = $this->chkFile($file); if (! $fil) return;
	$ext = FSO::ext($fil);

	$cod = new code();
	$erg = $cod->read($fil); if (! $erg) return;

	$this->mergex($this->sec, $cod->getSecs()); if (! $this->sealed)
	$this->mergex($this->typ, $cod->getTypes());
	$this->mergex($this->vrs, $cod->getVars());
	$this->mergex($this->vls, $cod->getValues());
	$this->chkUID();
}

protected function mergex(&$dst, $arr) {
	foreach ($arr as $key => $val) {
		if ($this->sealed) if (! isset($dst[$key])) continue;
		$dst[$key] = $val;
	}
}

protected function seal() {
	$this->sealed = true;
}

// ***********************************************************
// editing info
// ***********************************************************
public function validTypes() {
	$ini = new ini("LOC_CFG/ptypes.def");
	$par = $this->parentType(); if (! $par) $par = "default";
	$par = $this->findSec($par, "default");
	return $ini->getValues($par);
}

public function parentType() {
	$dir = dirname($this->dir);
	$ini = new ini($dir);
	return $ini->getType();
}

// ***********************************************************
// language specific methods
// ***********************************************************
protected function langSec($sec) {
	foreach (LNG::getRel() as $lng) { // find first relevant language section
		if ($this->isSec("$sec.$lng")) return "$sec.$lng";
	}
	return $sec;
}

private function langProp($prop, $lng = CUR_LANG) {
	$lgs = array($lng => $lng);
	$lgs+= LNG::getRel();

	foreach ($lgs as $lng) {
		$out = self::get("$lng.$prop"); if ($out) return $out;
	}
	return self::get($prop, false);
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
protected function chkUID() {
	if (! $this->isKey("props.uid")) return;
	$uid = $this->get("props.uid", "GET_UID"); if ($uid != "GET_UID") return;
	$this->set("props.uid", $this->getUID());
}

public function chkValue($val, $sec) {
	if ($val == "GET_UID")    return $this->getUID();
	if ($val == "DIR_NAME")   return $this->getDir();
	if ($val == "GET_DIR")    return $this->dir;
	if ($val == "GET_TITLE")  return $this->getTitle($sec);
	if ($val == "GET_HEAD")   return $this->getHead($sec);
	if ($val == "NODE_TYPES") return "include";

	if (is_array($val)) {
		return array_key_first($val);
	}
	$val = STR::before($val, "|");
	$val = STR::before($val, ":=");

	return $val;
}

// ***********************************************************
private function isDefault($uid) { // default = name of containing dir
	if ($uid == "GET_UID") return true;
	if (! $uid) return true;
	if (strlen($uid) < 5) if (STR::begins($uid, "§")) return true;
	return false;
}

protected function isSec($sec) {
	return array_key_exists($sec, $this->sec);
}

// ***********************************************************
protected function chkFile($fil) {
	$chk = APP::dir($fil); if ($chk)
	$fil = FSO::join($fil, $this->fname);
	$ful = APP::file($fil);

	$this->dir = dirname($fil);
	$this->file = $fil;

	return $fil;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
