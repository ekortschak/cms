<?php
/* ***********************************************************
// INFO
// ***********************************************************
used to handle ini files

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

	protected $sec = array();
	protected $typ = array();
	protected $vrs = array();

	protected $dir = "";
	protected $file = "";
	protected $fname = "page.ini";


function __construct($fso) {
	$this->read($fso);
}

// ***********************************************************
// handling vars
// ***********************************************************
public function vars() {
	return $this->vrs;
}

public function values($sec = "") {
	if ($sec) $sec = $this->langSec($sec);
	if ($sec) if (! STR::ends($sec, ".")) $sec.= ".";

	$out = parent::values($sec);

	foreach ($out as $key => $val) {
		$out[$key] = $this->chkValue($val);
	}
	return $out;
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

protected function isSec($sec) {
	return array_key_exists($sec, $this->sec);
}

// ***********************************************************
// handling UIDs
// ***********************************************************
public function UID() {
 // uniqueness handled by PFS
	$uid = $this->get("props.uid");
	if ( ! $this->isDefault($uid)) return $uid;
	return $this->getDefault();
}

private function isDefault($uid) {
	if (STR::begins($uid, "§")) return true;
	if ($uid == "GET_UID") return true;
	if ($uid == "Config") return true;
	if ($uid) return false;
	return true;
}
private function getDefault() {
	$uid = $this->title(); if ($uid) return STR::camel($uid);
	$uid = $this->name();  if ($uid != "Config") return $uid;
	return "§".uniqid();
}

// ***********************************************************
// handling properties
// ***********************************************************
public function dir()  { return $this->dir;  }
public function file() { return $this->file; }

private function name() {
	$out = basename($this->dir);
	$out = PRG::clrDigits($out);
	return ucfirst($out);
}

public function target() {
	return $this->get("props_red.trg");
}

// ***********************************************************
public function title($lng = CUR_LANG) {
	$tit = $this->langProp("title");
	$out = $this->scrTitle($tit); if ($out) return $out;
	$out = $this->chkTitle($tit); if ($out) return $out;
	return $this->name();
}

private function chkTitle($txt) {
	if ($txt == "GET_TITLE") return false;
	return $txt;
}

private function scrTitle($txt) {
	$scr = STR::after($txt, "script:"); if (! $scr) return false;
	$scr = FSO::join($this->dir, $scr);
	$out = APP::gcFile($scr); if ($out) return $out;
	return false;
}

// ***********************************************************
public function head($lng = CUR_LANG) {
	$out = $this->lng("head");
	$out = STR::clear($out, "GET_HEAD"); if ($out) return $out;
	return $this->title($lng);
}

// ***********************************************************
public function type($default = "inc") {
	$out = $this->get("props.typ", $default);
	return STR::left($out, 3);
}

// ***********************************************************
// reading ini files
// ***********************************************************
public function read($file) {
	$fil = $this->chkFile($file); if (! $fil) return;

	$cod = new code();
	if (! $cod->read($fil)) return;

	$this->mergex($this->sec, $cod->getSecs()); if (! $this->sealed)
	$this->mergex($this->typ, $cod->getTypes());
	$this->mergex($this->vrs, $cod->getVars());
	$this->mergex($this->vls, $cod->values());
}

protected function mergex(&$dst, $arr) {
	foreach ($arr as $key => $val) {
		if ($this->sealed) if (! isset($dst[$key])) continue;
		$dst[$key] = $val;
	}
}

// ***********************************************************
// editing info
// ***********************************************************
public function validTypes() {
	$ini = new ini("LOC_CFG/ptypes.def");
	$par = $this->parentType(); if (! $par) $par = "default";
	$par = $this->findSec($par, "default");
	return $ini->values($par);
}

public function parentType() {
	$dir = dirname($this->dir);
	$ini = new ini($dir);
	return $ini->type();
}

public function chkValue($val, $sec = NV) {
	if ($val == "GET_UID")    return $this->UID();
	if ($val == "GET_TITLE")  return $this->title($sec);
	if ($val == "GET_HEAD")   return $this->head($sec);
	if ($val == "DIR_NAME")   return $this->name();

	if ($val == "NODE_TYPES") return "include";

	if (is_array($val)) {
		return array_key_first($val);
	}
	$val = STR::before($val, "|");
	$val = STR::before($val, ":=");
	return $val;
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
