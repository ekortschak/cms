<?php
/* ***********************************************************
// INFO
// ***********************************************************
search pages for content

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("search/sBasics.php");

$obj = new sBasics();
$opt = $obj->getScope();
$lst = $obj->getResults($fnd); // list of dirs with matching files

$tit = $obj->getTitle($fil);
$lst = $obj->getSnips($dir, $fnd); // list of files and matching snips

*/

incCls("menus/dropBox.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class sBasics {
	protected $rng = TAB_HOME;
	protected $vis = true;
	protected $mod = "p";

	const SEP = "@Q@";

function __construct($dir = TAB_HOME) {
	$this->rng = ENV::get("search.rng", $dir);
	$this->mod = ENV::get("search.mod", $this->mod);

	$this->chkReset();
}

// ***********************************************************
// determining scope
// ***********************************************************
public function getScope() {
	$drs = $this->getPaths();
	$mds = $this->getMods();

	$box = new dropBox("menu");
	$this->rng = $box->getKey("search.rng", $drs, $this->rng);
	$this->mod = $box->getKey("search.mod", $mds, $this->mod);
	return $box->gc("menu");
}

protected function isScope($dir) {
// dummy to be overruled by derived classes
	return true;
}

// ***********************************************************
// retrieving relevant files
// ***********************************************************
public function getResults($what) {
#	$out = $this->isSame($what); if ($out) return $out;
#	$xxx = $this->saveParms("");

	$psg = $this->search($what); if (! $psg) return false;
	$psg = $this->sort($psg);
	$out = array();

	foreach ($psg as $fil) {
		$tab = $this->getTab($fil);
		$out[$tab][$fil] = PGE::title($fil);
	}
	$this->saveParms($out);
	return $out;
}

protected function getTab($fil) {
	$tab = STR::between($fil, TAB_ROOT.DIR_SEP, DIR_SEP);
	return FSO::JOIN(TAB_ROOT, $tab);
}

// ***********************************************************
protected function search($what) { // $what expected as string
	if (strlen($what) < 2) return false;

	$arr = FSO::dTree($this->rng);
	$out = array();

	foreach ($arr as $dir => $nam) {
		if (! $this->isScope($dir)) continue;
		$fls = FSO::files($dir); if (! $fls) continue;

		foreach ($fls as $fil => $nam) {
			if (! LNG::isCurrent($fil)) continue;

			$txt = $this->prepare($fil);      if (! $txt) continue;
			$psg = $this->match($txt, $what); if (! $psg) continue;
			$out[$dir] = $dir;
		}
	}
	return $out;
}

// ***********************************************************
// retrieving relevant passages from files
// ***********************************************************
public function getSnips($dir, $what) { // called by preview
	$arr = FSO::files($dir); $out = array();

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
protected function saveParms($val) {
	ENV::set("search.last", $val);
}
protected function getParms($what) {
	return STR::join($this->rng, $this->mod, $what);
}

// ***********************************************************
// helper methods for scope
// ***********************************************************
protected function getPaths() {
	$dir = dirname(TAB_HOME);
	$fil = FSO::join($dir, "tab.ini");

	$ini = new ini($fil);
	$typ = $ini->getType();

	if ($typ != "sel") $dir = TAB_HOME;

	return array(
		TAB_HOME => DIC::get("Local"),
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
		$txt = STR::replace($txt, "<h$i>", self::SEP."<h$i>");
	}
	return $txt;
}

protected function prepare_p($txt) {
	$txt = $this->prepare_h($txt);
	$txt = STR::replace($txt, "<p>", self::SEP."<p>");
	$txt = STR::replace($txt, "<p ", self::SEP."<p ");
	return $txt;
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
protected function chkReset() {
	if (! ENV::getParm("search.reset")) return;

	ENV::set("search.what",  false);
	ENV::set("search.parms", false);
	ENV::set("search.last",  false);
}

protected function getContent($file) {
	$ext = FSO::ext($file);	if (STR::misses(".php.htm.", $ext)) return false;
	$out = APP::read($file);
	$out = STR::replace($out, "<?php ", "<php>");
	$out = STR::replace($out, "?>", "</php>");
	$out = PRG::clrTag($out, "refbox");
	return $out;
}

// ***********************************************************
protected function match1st($txt, $find) {
	$arr = STR::split($txt, self::SEP); $out = array();

	foreach ($arr as $pgf) {
		$chk = strip_tags($pgf); if (! STR::matches($chk, $find)) return true;
	}
	return false;
}

protected function match($txt, $find) {
	$arr = STR::split($txt, self::SEP); $out = array();

	foreach ($arr as $pgf) {
		$chk = strip_tags($pgf); if (! STR::matches($chk, $find)) continue;
		$out[] = $pgf;
	}
	return $out;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
