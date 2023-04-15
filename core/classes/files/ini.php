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
	protected $sealed = false;
	protected $silent = true;

	protected $sec = array();
	protected $typ = array();
	protected $vrs = array();

	protected $dir = "";
	protected $file = "";
	protected $fname = "page.ini";

function __construct($fso = CUR_PAGE) {
	$this->read($fso);
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

public function dropSec($sec) {
	unset($this->sec[$sec]);
}

// ***********************************************************
public function setSec($sec, $data) {
	$this->sec[$sec] = $data;
}

public function getSec($sec) {
	$sec = $this->findSec($sec); if (! $sec) return "";
	return $this->sec[$sec];
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
public function setSealed($value) {
	$this->sealed = (bool) $value;
}

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
	return $this->getDirName();
}

public function getDirName() {
	$dir = basename($this->dir);
	return PRG::clrDigits($dir);
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
	$out = APP::gc($scr); if ($out) return $out;
	return false;
}

// ***********************************************************
public function getHead($lng = CUR_LANG) {
	$out = $this->get("$lng.head");
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
	$fil = $this->chkFile($file);
	$ext = FSO::ext($fil);

	$cod = new code();
	$erg = $cod->read($fil); if (! $erg) return;

	$this->mergeSecs($cod->getSecs(), $cod->getTypes(), $ext);
	$this->mergeVars($cod->getVars());
	$this->mergeVals($cod->getValues());
	$this->chkUID();
}

protected function mergeSecs($secs, $types, $ext) {
	foreach ($secs as $key => $val) {
		if ($this->sealed) if (! $this->isKey($key)) continue;
		$this->sec[$key] = $val; if ($ext == "def")
		$this->typ[$key] = $types[$key];
	}
}

protected function mergeVars($arr) {
	foreach ($arr as $key => $val) {
		$this->vrs[$key] = $val;
	}
}

protected function mergeVals($arr) {
	foreach ($arr as $key => $val) {
		if ($this->sealed) if (! $this->isKey($key)) continue;
		$this->set($key, $val);
	}
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
	$out = $this->get("$lng.$prop");      if ($out) return $out;
	$out = $this->get(CUR_LANG.".$prop"); if ($out) return $out;
	$out = $this->get(GEN_LANG.".$prop"); if ($out) return $out;
	$out = $this->get("xx.$prop");        if ($out) return $out;
	$out = $this->get("$prop");           if ($out) return $out;
	return false;
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
protected function chkUID() {
	if (! $this->isKey("props.uid")) return;
	$uid = $this->get("props.uid", "GET_UID"); if ($uid != "GET_UID") return;
	$this->set("props.uid", $this->getUID());
}

protected function chkValue($val, $sec) {
	if ($val == "GET_UID")    return $this->getUID();
	if ($val == "DIR_NAME")   return $this->getDirName();
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

	$this->dir = dirname($fil);
	$this->file = $fil;

	return $fil;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
