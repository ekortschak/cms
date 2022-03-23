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

$dir = APP::dir(__DIR__);

$nav = new buttons("anyID", "A", $dir);
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
	private $own = "";
	private $std = "";

function __construct($owner, $std, $dir) {
	$this->own = "btn.$owner";
	$this->std = $std;
	$this->dir = $dir;

	$this->read("design/templates/menus/buttons.tpl");

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

// ***********************************************************
// display buttons
// ***********************************************************
public function show($sec = "main") {
	$out = implode("\n", $this->dat);
	$this->set("items", $out);
	echo parent::gc($sec);
}

// ***********************************************************
// show file
// ***********************************************************
public function showContent() {
	$sel = ENV::get($this->own, $this->std);
	$fil = VEC::get($this->fls, $sel);

	if (! $fil) return $this->show("wrong.btn");
	include_once($fil);
}

public function getFile() {
	$sel = ENV::get($this->own, $this->std);
	$out = VEC::get($this->fls, $sel);
	$out = FSO::clearRoot($out);
	$out = APP::file($out);;
	return $out;
}

// ***********************************************************
// create missing files
// ***********************************************************
private function chkPhp($qid, $php) {
	if (is_file($php)) return $php; $dir = $this->dir;

	$fil = "$dir/$php.php"; if (is_file($fil)) return $fil;
	$fil = "$dir/$php.htm"; if (is_file($fil)) return $fil;

	APP::write($fil, "$qid\n\n<?php echo NV; ?>");
}

private function chkIni($qid, $ini) {
	if (is_file($ini)) return $ini; $fil = FSO::join($this->dir, "$ini.ini");
	if (is_file($fil)) return $fil; $glb = APP::file("design/buttons/$ini.ini");
	if (is_file($glb)) return $glb;

	$dir = $this->dir;
	$fil = "$dir/$ini.ini"; if (is_file($fil)) return $fil;

	FSO::copy("design/config/button.ini", $fil);
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
