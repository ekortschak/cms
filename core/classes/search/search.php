<?php
/* ***********************************************************
// INFO
// ***********************************************************
search web files for content

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("search/search.php");

$obj = new swrap();
$opt = $obj->getScope();
$lst = $obj->getResults($fnd);

$tit = $obj->getTitle($fil);
$ref = $obj->getInfo($fil);
$txt = $obj->getSnips($fil, $fnd);

*/

incCls("menus/localMenu.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class search {
	protected $dir = TAB_PATH;
	protected $vis = true;
	protected $sep = "@Q@";
	protected $mod = "p";

function __construct($dir = TAB_PATH) {
	$this->dir = ENV::get("search.dir", $dir);
	$this->mod = ENV::get("search.mod", $this->mod);
}

// ***********************************************************
// methods called by toc
// ***********************************************************
public function getScope() {
	$drs = $this->getPaths();
	$mds = $this->getMods();

	$box = new localMenu();
	if (count($drs) > 1) $this->dir = $box->getKey("search.dir", $drs, TAB_PATH);
	if (count($mds) > 1) $this->mod = $box->getKey("search.mod", $mds, "h");
	return $box->gc("compact");
}

// ***********************************************************
public function getResults($what) {
	$out = $this->isSame($what); if (  $out) return $out;
	$psg = $this->search($what); if (! $psg) return DIC::get("no.match");
	$out = array();

	foreach ($psg as $fil => $txt) {
		$ref = $this->getInfo($fil); if (! $ref) continue;
		$tit = $this->getTitle($fil, $ref);
		$tab = $ref["tab"];

		$out[$tab][$fil] = $tit;
	}
	ENV::set("last.search", $out);
	return $out;
}

// ***********************************************************
protected function search($what) { // $what expected as string
	if (strlen($what) < 2) return false;

	$arr = FSO::tree($this->dir);
	$loc = PFS::getLoc();
	$out = array();

	foreach ($arr as $dir => $nam) {
		$fls = FSO::files("$dir/*.*"); if (! $fls) continue;

		foreach ($fls as $fil => $nam) {
			if (! LNG::isCurLang($fil)) continue;

			$src = $this->getSource($fil);
			$txt = $this->prepare($src);      if (! $txt) continue;
			$psg = $this->match($txt, $what); if (! $psg) continue;

			foreach ($psg as $key => $val) {
				$idx = $this->getIndex($fil, $key);
				$key = $this->getKey($fil, $key);
				$val = $this->getEntry($val);

				if (! isset($out[$idx])) $out[$idx] = array();
				$out[$idx][$key] = $val;
			}
		}
	}
	return $this->sort($out);
}

// ***********************************************************
 // dummies for derived classes
// ***********************************************************
protected function getIndex($fil, $key) { return $fil; }
protected function getKey  ($fil, $key) { return $key; }
protected function getEntry($val)       { return $val; }
protected function sort($arr)           { return $arr; }

// ***********************************************************
// methods called by preview
// ***********************************************************
public function getTitle($file) {
	$ini = new ini(dirname($file));
	return $ini->getHead();
}

// ***********************************************************
public function getInfo($file) {
	$ful = APP::relPath($file);
	$fil = basename($file);
	$dir = dirname($ful);
	$tab = STR::between($dir, TAB_ROOT, DIR_SEP);

	$out = array(
		"tab" => TAB_ROOT.$tab, "file" => $fil,
		"url" => $dir
	);
	return $out;
}

// ***********************************************************
public function getSnips($file, $what) { // called by preview
	$txt = $this->prepare($file);
	$arr = $this->match($txt, $what);

	$out = implode("<hr class=\"search\">\n", $arr);
	$out = STR::clear($out, $this->sep);
	return $out;
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
protected function getContent($file) {
	$ext = FSO::ext($file);	if (! STR::contains(".php.htm.", $ext)) return false;
	$out = APP::read($file);
	$out = PRG::clrTag($out, "refbox");
	return $out;
}

// ***********************************************************
protected function match($txt, $find) {
	$arr = STR::split($txt, $this->sep); $out = array();

	foreach ($arr as $pgf) {
		$chk = strip_tags($pgf); if (! STR::matches($chk, $find)) continue;
		$out[] = $pgf;
	}
	return $out;
}

// ***********************************************************
protected function getPaths() {
	$dir = dirname(TAB_PATH);
	$fil = FSO::join($dir, "tab.ini");

	$ini = new ini($fil);
	$typ = $ini->get("props.typ");

	if ($typ != "select") $dir = TAB_PATH;

	return array(
		TAB_PATH => DIC::get("Local"),
		$dir => DIC::get("Global"),
	);
}
protected function getMods() {
	return array(
		"h" => DIC::get("Sections"),
		"p" => DIC::get("Paragraphs"),
	);
}

// ***********************************************************
// verify if search context has changed
// ***********************************************************
protected function isSame($what) {
	$chk = $this->getParms($what);
	$lst = ENV::get("last.parms");

	if ($lst != $chk) {
		ENV::set("last.parms", $chk);
		return false;
	}
	return ENV::get("last.search");
}

protected function getParms($what) {
	return STR::join($this->dir, $this->mod, $what);
}

// ***********************************************************
// split text
// ***********************************************************
protected function prepare($src) {
	$txt = $this->getContent($src); if (! $txt) return "";

	switch ($this->mod) {
		case "h": return $this->prepare_h($txt);
		case "p": return $this->prepare_p($txt);
	}
	return $txt;
}

protected function prepare_h($txt) {
	for ($i = 1; $i < 6; $i++) {
		$txt = STR::replace($txt, "<h$i>", $this->sep."<h$i>");
	}
	return $txt;
}

protected function prepare_p($txt) {
	$txt = $this->prepare_h($txt);
	$txt = STR::replace($txt, "<p>", $this->sep."<p>");
	$txt = STR::replace($txt, "<p ", $this->sep."<p ");
	return $txt;
}

// ***********************************************************
// dummy methods for derived classes
// ***********************************************************
protected function getSource($file) { // dummy method for derived classes
	return $file;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
