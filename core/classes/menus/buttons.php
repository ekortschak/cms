<?php
/* ***********************************************************
// INFO
// ***********************************************************
Handles top navigation by buttons

2 files are required going by the same name
* an include file
* an ini file

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("menus/buttons.php");

$nav = new buttons("anyID", "A", __DIR__);
$nav->add("A", "incA");
$nav->add("B", "incB");
$nav->align("L" | "C" | "R");
$nav->add("C", "incC");
$nav->show();

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
	private $idx = 1;  // button group

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
	$inc = $this->chkPhp($file);
	$ini = $this->chkIni($ini);
	$cls = ($sel == $qid) ? "selected" : "";

	$btn = new button();
	$btn->read($ini);
	$btn->set("qid", $qid);

	$lnk = $btn->get("link"); if (! $lnk)
	$xxx = $btn->set("link", "?$own=$qid");
	$xxx = $btn->set("class", $cls);

	$this->dat[$this->idx][$qid] = $btn->gc();
	$this->fls[$qid] = $inc;
}

public function link($qid, $caption, $url) {
	$sel = ENV::get($this->own, $this->std);

	$btn = new button();
	$btn->set("qid", $qid);
	$btn->set("caption", DIC::get($caption));
	$btn->set("link", $url);

	$this->dat[$this->idx][$qid] = $btn->gc("link");
}

public function space() {
	$this->idx++;
}

// ***********************************************************
// display buttons
// ***********************************************************
public function show($sec = "main") {
	$out = "";

	foreach ($this->dat as $idx => $inf) {
		$htm = implode("\n", $inf);
		$this->set("group", $htm);

		$out.= parent::gc("group");
	}
	$this->set("items", $out);
	echo parent::gc($sec);

	$this->showContent();
}

public function act() {
	return ENV::get($this->own, $this->std);
}

// ***********************************************************
// show file
// ***********************************************************
private function showContent() {
	$sel = ENV::get($this->own, $this->std);
	$inc = VEC::get($this->fls, $sel);

	if (! $inc) return $this->show("wrong.btn");
	include_once $inc;
}

public function getFile() {
	$sel = ENV::get($this->own, $this->std);
	$out = VEC::get($this->fls, $sel);
	return APP::file($out);
}

// ***********************************************************
// create missing files
// ***********************************************************
private function chkPhp($php) {
	if (is_file($php)) return $php;

	$dir = APP::relPath($this->dir);
	$fil = FSO::join($dir, "$php.php"); if (APP::file($fil)) return $fil;
	$htm = FSO::join($dir, "$php.htm"); if (APP::file($htm)) return $htm;

	if (APP_CALL != "index.php") return $fil;

	FSO::copy("LOC_CFG/button.def", $fil);
	return $fil;
}

private function chkIni($btn) {
	if (is_file($btn)) return $btn;

	$dir = APP::relPath($this->dir);
	$fil = FSO::join($dir,   "$btn.btn"); if (APP::file($fil)) return $fil;
	$glb = APP::file("LOC_BTN/$btn.btn"); if (APP::file($glb)) return $glb;

	if (APP_CALL != "index.php") return $fil;

	FSO::copy("LOC_CFG/button.def", $fil);
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
