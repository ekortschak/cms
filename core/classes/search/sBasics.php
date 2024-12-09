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
$opt = $obj->scope();
$lst = $obj->results($fnd); // list of dirs with matching files

$tit = $obj->title($fil);
$lst = $obj->snips($dir, $fnd); // list of files and matching snips

*/

incCls("menus/dropBox.php");

// ***********************************************************
// check for reset
// ***********************************************************
if (ENV::getParm("search.reset")) {
	ENV::set("search.what",  false);
	ENV::set("search.parms", false);
	ENV::set("search.last",  false);
	ENV::set("search.help",  0);
}

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class sBasics {
	protected $rng = TAB_HOME;
	protected $vis = true;
	protected $mod = "p";
	protected $hlp = false;
	protected $fnd = false;

	const SEP = "@Q@";

function __construct($dir = TAB_HOME) {
	$this->rng = ENV::get("search.rng", $dir);
	$this->mod = ENV::get("search.mod", $this->mod);
	$this->hlp = ENV::get("search.help", 0);

	$this->fnd = $this->findWhat();
}

// ***********************************************************
// display form and results
// ***********************************************************
public function show() {
	$this->showForm();
	$this->results();
}

private function showForm() {
	$fnd = $this->fnd;
	$hlp = $this->hlp;

	$tpl = new tpl();
	$tpl->load("modules/search.tpl");
	$tpl->set("range",  $this->scope());
	$tpl->set("search", $this->fnd);

	if ($fnd && $hlp)
	$tpl->substitute("help", "nohelp");
	$tpl->show();

	if ((! $fnd) || ($hlp))
	$tpl->show("howto");
}

// ***********************************************************
// determining scope
// ***********************************************************
public function scope() {
	$drs = $this->paths();
	$mds = $this->mods();

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
public function findWhat() {
	$out = ENV::find("search.what");
	$out = STR::replace($out, '"', "'");
	return $out;
}

// ***********************************************************
// retrieving relevant files
// ***********************************************************
public function results() {
	$fnd = $this->fnd;
	$out = $this->isSame($fnd); if ($out) return $out;
	$xxx = $this->saveParms("");
	$psg = $this->search($fnd); if (! $psg) return false;
	$psg = $this->sort($psg);
	$out = array();

	foreach ($psg as $fil) {
		$tab = $this->tab($fil);
		$out[$tab][$fil] = PGE::title($fil);
	}
	$this->saveParms($out);
	return VEC::sort($out);
}

protected function tab($fil) {
	$tab = STR::between($fil, TAB_ROOT.DIR_SEP, DIR_SEP);
	return FSO::JOIN(TAB_ROOT, $tab);
}

// ***********************************************************
protected function search($what) { // $what expected as string
	if (strlen($what) < 2) return false;

	$arr = FSO::dTreeX($this->rng);
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
public function snips($dir, $what) { // called by preview
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
protected function parms($what) {
	return STR::join($this->rng, $this->mod, $what);
}

// ***********************************************************
// helper methods for scope
// ***********************************************************
protected function paths() {
	$dir = dirname(TAB_HOME);
	$fil = FSO::join($dir, "tab.ini");

	$ini = new ini($fil);
	$typ = $ini->type();

	if ($typ != "sel") $dir = TAB_HOME;

	return array(
		TAB_HOME => DIC::get("search.one"),
		$dir => DIC::get("search.all"),
	);
}

protected function mods() {
	return array(
		"p" => DIC::get("Paragraphs"),
		"h" => DIC::get("Sections"),
	);
}

// ***********************************************************
// verify if search context has changed
// ***********************************************************
protected function isSame($what) {
return false;
	if (strlen($what) < 3) return true;

	$chk = $this->parms($what);
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
	$txt = $this->read($src); if (! $txt) return "";
	$fnc = "prepare_".$this->mod;
	return $this->$fnc($txt);
}

protected function prepare_h($txt) {
	for ($i = 1; $i < 6; $i++) {
		$txt = STR::replace($txt, "<h$i>", self::SEP."<h$i>");
	}
	return $txt;
}

protected function prepare_p($txt) {
#	$txt = $this->prepare_h($txt);
	$txt = STR::replace($txt, "<p>", self::SEP."<p>");
	$txt = STR::replace($txt, "<p ", self::SEP."<p ");
	return $txt;
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
protected function read($file) {
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
		if ($this->mod == "p") $pgf = STR::before($pgf, "<h");

		$chk = strip_tags($pgf); if (! STR::matches($chk, $find)) continue;
		$out[] = $pgf;
	}
	return $out;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
