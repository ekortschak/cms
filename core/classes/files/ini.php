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
	protected $sec = array();

	protected $dir = "";
	protected $file = "";
	protected $fname = "page.ini";

	protected $sealed = false;

function __construct($fso = "CURDIR") {
	if ($fso == "CURDIR") $fso = PFS::getLoc();
	$this->read($fso);
}

// ***********************************************************
// handling sections
// ***********************************************************
public function getValues($sec = "*") {
	if ($sec == "*") return parent::getValues();
	$sec = $this->getLangSec($sec);
	return parent::getValues($sec);
}

public function getSecs($pfx = "", $filter = true) {
	$arr = $this->sec; $out = array();
	$ign = STR::toArray("dic,include,register");

	foreach ($this->sec as $sec => $val) {
		if ($filter)
		if (STR::begins($sec, $ign)) continue;
		if (STR::begins($sec, $pfx)) $out[$sec] = $sec;
	}
	return $out;
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
	$uid = $this->get("props.uid"); if ($uid) return $uid;
	return $this->getName();
}

public function getTitle($lng = CUR_LANG) {
	$out = $this->getLang("title"); if ($out) return $out;
	$out = $this->getName();
	return ucfirst($out);
}

public function getHead($lng = CUR_LANG) {
	$out = $this->getLang("head"); if ($out) return $out;
	return $this->getTitle($lng);
}

private function getLang($prop) {
	$out = $this->get(CUR_LANG.".$prop"); if ($out) return $out;
	$out = $this->get(GEN_LANG.".$prop"); if ($out) return $out;
	$out = $this->get("xx.$prop");        if ($out) return $out;
	$out = $this->get("$prop");           if ($out) return $out;
	return false;
}

public function getType($default = "inc") {
	$typ = $this->get("props.typ"); if (! $typ) $typ = $default;
	return STR::left($typ);
}
public function getIncFile($typ = "inc") {
	$typ = $this->getType($typ);

	if ($typ == "roo") return "include.php";  // root
    if ($typ == "inc") return "include.php";  // default mode
	if ($typ == "col") { // collection of files (still working ?)
		if (ENV::get("vmode") == "xform") return "collect.xsite.php";
		return "collect.php";
	}
	if ($typ == "red") return "redirect.php"; // redirection to another local directory
	if ($typ == "lin") return "redirect.php"; // internal link = redirect
	if ($typ == "url") return "links.php";    // external link

	if ($typ == "mim") return "mimeview.php"; // show files
	if ($typ == "dow") return "gallery.php";  // download
    if ($typ == "gal") return "gallery.php";  // show files
    if ($typ == "upl") return "upload.php";   // upload
	if ($typ == "cam") return "livecam.php";  // camera

	if ($typ == "dbt") return "dbtable.php";  // database table
    if ($typ == "sur") return "survey.php";   // survey
    if ($typ == "tut") return "tutorial.php"; // tutorial
	return false;
}

protected function getName() {
	$out = basename($this->dir);
	return PRG::clrDigits($out);
}

// ***********************************************************
// reading ini files
// ***********************************************************
public function read($file) {
	$this->setFile($file);

	$cod = new code();
	$cod->read($this->file);

	$this->sec = array_merge($this->sec, $cod->getSecs());
	$this->merge($cod->getValues());
	$this->chkUID();
}

public function merge($arr) {
	foreach ($arr as $key => $val) {
		if ($this->sealed) if (! $this->isKey($key)) continue;
		$this->set($key, $val);
	}
}

// ***********************************************************
// editing info
// ***********************************************************
public function validTypes() {
	$ini = new ini("design/config/ptypes.ini");
	$par = $this->parentType(); if (! $par) $par = "default";
	$par = $this->findSec($par, "default");
	return $ini->getValues($par);
}

public function parentType() {
	$dir = dirname($this->dir);
	$ini = new ini($dir);
	return $ini->get("props.typ", "inc");
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
protected function getLangSec($sec) {
	foreach (LNG::getRel() as $lng) {
		if ($this->isSec("$sec.$lng")) return "$sec.$lng";
	}
	return $sec;
}
protected function isSec($sec) {
	return array_key_exists($sec, $this->sec);
}

protected function setFile($fil) {
	$chk = APP::dir($fil); if ($chk)
	$fil = FSO::join($fil, $this->fname);

	$this->dir = dirname($fil);
	$this->file = $fil;
}

protected function chkUID() {
	if ($this->isKey("props.uid"))
	$this->set("props.uid", $this->getUID());
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
