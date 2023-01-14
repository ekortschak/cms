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
$lst = $obj->getResults($fnd); // list of dirs with matching files

$tit = $obj->getTitle($fil);
$lst = $obj->getSnips($dir, $fnd); // list of files and matching snips

*/

incCls("menus/dropMenu.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class search {
	protected $dir = TAB_PATH;
	protected $vis = true;
	protected $sep = "@Q@";
	protected $mod = "p";

function __construct($dir = TAB_PATH) {
	$this->dir = ENV::get("search.tpc", $dir);
	$this->mod = ENV::get("search.mod", $this->mod);

	$this->chkReset();
}

// ***********************************************************
// determining scope
// ***********************************************************
public function getScope() {
	$drs = $this->getPaths();
	$mds = $this->getMods();

	$box = new dropMenu();
	if (count($drs) > 1) $this->dir = $box->getKey("search.tpc", $drs, TAB_PATH);
	if (count($mds) > 1) $this->mod = $box->getKey("search.mod", $mds, $this->mod);
	return $box->gc("menu");
}

protected function isScope($dir) {
	return true;
}

// ***********************************************************
// retrieving relevant files
// ***********************************************************
public function getResults($what) {
	$out = $this->isSame($what); if (  $out) return $out;
	$xxx = $this->saveRes("");   if (strlen($what) < 2) return;

	$psg = $this->search($what); if (! $psg) return false;
	$psg = $this->sort($psg);
	$out = array();

	foreach ($psg as $fil) {
		$tab = $this->getTab($fil);
		$tit = PGE::getTitle($fil, $tab);

		$out[$tab][$fil] = $tit;
	}
	$this->saveRes($out);
	return $out;
}

// ***********************************************************
protected function search($what) { // $what expected as string
	if (strlen($what) < 2) return false;

	$arr = FSO::tree($this->dir);
	$out = array();

	foreach ($arr as $dir => $nam) {
		if (! $this->isScope($dir)) continue;
		$fls = FSO::files("$dir/*.*"); if (! $fls) continue;

		foreach ($fls as $fil => $nam) {
			if (! LNG::isCurrent($fil)) continue;

			$txt = $this->prepare($fil);      if (! $txt) continue;
			$psg = $this->match($txt, $what); if (! $psg) continue;

			$out[$dir] = $dir;
		}
	}
	return $this->sort($out);
}

// ***********************************************************
// retrieving relevant passages from files
// ***********************************************************
public function getSnips($dir, $what) { // called by preview
	$arr = FSO::files("$dir/*"); $out = array();

	foreach ($arr as $fil => $nam) {
		if (! LNG::isCurrent($fil)) continue;

		$txt = $this->prepare($fil);
		$arr = $this->match($txt, $what); if (! $arr) continue;
		$out[$fil] = $arr;
	}
	return $out;
}

// ***********************************************************
// methods to be overruled by derived classes
// ***********************************************************
protected function sort($arr) {
	return $arr;
}
protected function getTab($dir) {
	$out = STR::between($dir, $this->dir.DIR_SEP, DIR_SEP);
	return FSO::join($this->dir, $out);
}
protected function saveRes($val) {
	ENV::set("search.last", $val);
}
protected function getParms($what) {
	return STR::join($this->dir, $this->mod, $what);
}

// ***********************************************************
// helper methods for scope
// ***********************************************************
protected function getPaths() {
	$dir = dirname(TAB_PATH);

	$fil = FSO::join($dir, "tab.ini");
	$typ = PGE::prop($fil, "props.typ");

	if ($typ != "select") $dir = TAB_PATH;

	return array(
		TAB_PATH => DIC::get("Local"),
		$dir => DIC::get("Global"),
	);
}

protected function getMods() {
	return array(
		"p" => DIC::get("Paragraphs"),
		"h" => DIC::get("Sections"),
	);
}

// ***********************************************************
// verify if search context has changed
// ***********************************************************
protected function isSame($what) {
	if (strlen($what) < 3) return true;

	$chk = $this->getParms($what);
	$lst = ENV::get("search.parms");

	if ($lst != $chk) {
		ENV::set("search.parms", $chk);
		return false;
	}
	return ENV::get("search.last");
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
// auxilliary methods
// ***********************************************************
protected function chkReset() {
	$rst = ENV::getParm("search.reset"); if (! $rst) return;
	ENV::set("search", false);
	ENV::set("search.parms", false);
	ENV::set("search.last", false);
}

protected function getContent($file) {
	$ext = FSO::ext($file);	if (! STR::contains(".php.htm.", $ext)) return false;
	$out = APP::read($file);
	$out = STR::replace($out, "<?php ", "<php>");
	$out = STR::replace($out, "?>", "</php>");
	$out = PRG::clrTag($out, "refbox");
	return $out;
}

// ***********************************************************
protected function match1st($txt, $find) {
	$arr = STR::split($txt, $this->sep); $out = array();

	foreach ($arr as $pgf) {
		$chk = strip_tags($pgf); if (! STR::matches($chk, $find)) return true;
	}
	return false;
}

protected function match($txt, $find) {
	$arr = STR::split($txt, $this->sep); $out = array();

	foreach ($arr as $pgf) {
		$chk = strip_tags($pgf); if (! STR::matches($chk, $find)) continue;
		$out[] = STR::clear($pgf, $this->sep);
	}
	return $out;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
