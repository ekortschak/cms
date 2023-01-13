<?php
/* ***********************************************************
// INFO
// ***********************************************************
Handles top navigation by buttons

2 files required going by the same name
* an include file
* an ini file

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("menus/buttons.php");

$nav = new buttons("anyID", "A", __DIR__);
$nav->add("A", "incA");
$nav->add("B", "incB");
$nav->add("C", "incC");
$nav->show();

$nav->showContent();

*/

incCls("input/button.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class buttons extends tpl {
	private $dat = array();
	private $fls = array();
	private $dir = "";
	private $own = ""; // selected button
	private $std = ""; // default button

function __construct($owner, $std, $dir) {
	$this->own = "btn.$owner";
	$this->std = $std;
	$this->dir = FSO::norm($dir);

	$this->load("menus/buttons.tpl");
	$this->register();

	OID::set($this->oid, "sfx", $owner);
	ENV::setIf($this->own, $std);
}

function revert($option, $target) {
	$cur = ENV::get($this->own);
	if ($cur == $option) ENV::set($this->own, $target);
}

// ***********************************************************
// methods
// ***********************************************************
public function add($qid, $file, $ini = "") {
	if (! $ini) $ini = $file;

	$sel = ENV::get($this->own, $this->std);

	$own = $this->own;
	$inc = $this->chkPhp($qid, $file);
	$ini = $this->chkIni($qid, $ini);
	$cls = ($sel == $qid) ? "selected" : "";

	$btn = new button();
	$btn->read($ini);

	$lnk = $btn->get("link"); if (! $lnk)
	$xxx = $btn->set("link", "?$own=$qid");
	$xxx = $btn->set("class", $cls);

	$this->dat[$qid] = $btn->gc();
	$this->fls[$qid] = $inc;
}

public function addSpace($num = 5) {
	$qid = uniqid();
	$this->dat[$qid] = str_repeat("&nbsp ", $num);
	$this->fls[$qid] = false;
}

// ***********************************************************
// display buttons
// ***********************************************************
public function show($sec = "main") {
	$out = implode("\n", $this->dat);
	$this->set("items", $out);
	echo parent::gc($sec);
}

public function act() {
	return ENV::get($this->own, $this->std);
}

// ***********************************************************
// show file
// ***********************************************************
public function showContent() {
	$sel = ENV::get($this->own, $this->std);
	$inc = VEC::get($this->fls, $sel);

	if (! $inc) return $this->show("wrong.btn");
	include_once($inc);
}

public function getFile() {
	$sel = ENV::get($this->own, $this->std);
	$out = VEC::get($this->fls, $sel);
	$out = APP::file($out);
	return $out;
}

// ***********************************************************
// create missing files
// ***********************************************************
private function chkPhp($qid, $php) {
	if (is_file($php)) return $php;

	$dir = APP::relPath($this->dir);
	$fil = FSO::join($dir, "$php.php"); if (APP::file($fil)) return $fil;
	$htm = FSO::join($dir, "$php.htm"); if (APP::file($htm)) return $htm;

	if (APP_CALL != "index.php") return $fil;

	FSO::copy("LOC_CFG/button.ini", $fil);
	return $fil;
}

private function chkIni($qid, $ini) {
	if (is_file($ini)) return $ini;

	$dir = APP::relPath($this->dir);
	$fil = FSO::join($dir, "$ini.ini");   if (APP::file($fil)) return $fil;
	$glb = APP::file("LOC_BTN/$ini.ini"); if (APP::file($glb)) return $glb;

	if (APP_CALL != "index.php") return $fil;

	FSO::copy("LOC_CFG/button.ini", $fil);
	return $fil;
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function getPic($pic) {
	if (! $pic) return "";
	$this->set("pic", $pic);
	return $this->getSection("pic");
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
