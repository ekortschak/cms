<?php

/* ***********************************************************
// INFO
// ***********************************************************
used to inject refboxes (explanatory text) into pages

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("input/lookup.php");

$lup = new lookup();
$lup->read("lookup/xy.ini");
$lup->insert($text);

*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class lookup extends objects {
	protected $dat = array();  // words to find in a given text
	protected $prp = array();  // props defining how to display occurrences

	protected $tpl;
	protected $sec = "lookup"; // default template section
	protected $col = "green";  // default color
	protected $sep = ";";      // default string separator

	protected $len = 2;        // max. length of conjugated forms of lookup keys (i.e. length of possible endings)

function __construct() {
	$this->tpl = new tpl();
	$this->tpl->load("other/lookup.tpl");

	if (CUR_LANG == "de") $this->len = 3;

	$this->readRef();
}

// ***********************************************************
// read ini files
// ***********************************************************
public function readRef() {
	$arr = FSO::files("lookup", "*.ini"); if (! $arr) return false;

	foreach ($arr as $fil => $nam) {
		$this->read($fil);
	}
	return true;
}

public function read($fil) {
	if (! is_file($fil)) return;

	$ini = new ini($fil);
	$arr = $ini->getValues("data"); if (! $arr) return;
 	$prp = $ini->getValues("props");
 	$arr = VEC::sort($arr, "krsort");

	$set = basename($fil);
	$set = STR::before($set, ".");

	$this->prp[$set] = $prp;
	$this->dat[$set] = $arr;
}

// ***********************************************************
// handling template properties
// ***********************************************************
protected function setProp($key, $val) {
	$this->tpl->set($key, $val);
}

protected function getProp($set, $prop, $default) {
	$prp = VEC::get($this->prp, $set); if (! $prp) return $default;
	return VEC::get($prp, $prop, $default);
}

// ***********************************************************
// handling lookup strings
// ***********************************************************
public function insert($txt) {
	$txt = $this->inject($txt);

	foreach ($this->dat as $set => $lst) {
		$sep = $this->getProp($set, "sep", $this->sep);
		$sec = $this->getProp($set, "tplsec", $this->sec);
		$col = $this->getProp($set, "color",  $this->col);
		$xxx = $this->setProp("color", $col);

		$arr = $this->find($txt, $set);
		$lup = $this->getLup($set);

		foreach ($arr as $key) {
			$ref = $this->findKey($set, $key); if (! $ref) continue;
			$val = $this->findVal($set, $ref);
			$val = $this->insLFs($val, $sep);
			$val = $this->insHRef($val);

			$this->setProp("caption", $key);
			$this->setProp("info", "<b>$ref</b><br>$val");
			$this->setInfo($set, $ref, $val);

			$fnd = $this->embrace($lup, $key);
			$rep = $this->tpl->getSection($sec);

			$txt = STR::replace($txt, $fnd, $rep);
		}
		$txt = $this->cleanTags($txt, $lup);
	}
	return $txt;
}

// ***********************************************************
// remove lookup tags
// ***********************************************************
public function clear($txt) {
	foreach ($this->dat as $set => $lst) {
		$lup = $this->getLup($set);
		$fnd = $this->embrace($lup, "(.*?)");
		$txt = PRG::replace($txt, $fnd, '$1');
		$txt = STR::clear($txt, " ()");
	}
	return $txt;
}

protected function cleanDups($txt, $lup) {
	$txt = PRG::replace($txt, "<$lup><$lup>(.*?)</$lup>", "<$lup>$1");
	return $txt;
}

protected function cleanTags($txt, $lup) {
	for ($i = 1; $i <= 6; $i++) { // no lookup in headings
		$txt = $this->cleanTag($txt, $lup, "<h$i>", "</h$i>");
	}
	$txt = $this->cleanTag($txt, $lup, "<a", "</a>");
	$txt = $this->cleanTag($txt, $lup, "<\?", "\?>");
	return $txt;
}

protected function cleanTag($txt, $lup, $tag, $end) {
	return PRG::replace($txt, "$tag(.*?)<$lup>(.*?)</$lup>(.*?)$end", "$tag$1$2$3$end");
}

// ***********************************************************
// preparing text for quicker response times
// ***********************************************************
public function inject($txt) {
	foreach ($this->prp as $set => $prp) {
		$lup = $this->getLup($set);

		if (STR::contains($txt, "<$lup>")) continue;

		foreach ($this->dat[$set] as $key => $val) {
			if (! $key) continue;
			if (! STR::contains($txt, $key)) continue;

			$txt = $this->chkVal($txt, $val);
			$rep = $this->embrace($lup, $key);

			$fnd = PRG::quote($key);
			$txt = PRG::replaceWords($txt, $fnd, $rep);
		}
		$txt = $this->cleanTags($txt, $lup);
		$txt = $this->cleanDups($txt, $lup);
	}
	return $txt;
}

// ***********************************************************
// retrieving keys
// ***********************************************************
protected function find($txt, $set = false) {
	$lup = $this->getLup($set);
	return STR::find($txt, "<$lup>", "</$lup>");
}

protected function findKey($set, $key) {
	$arr = VEC::get($this->dat, $set); if (! $arr) return false;

	for ($i = 0; $i < $this->len; $i++) {
		$val = VEC::get($arr, $key); if ($val) return $key;
		$lng = strlen($key);
		$key = substr($key, 0, $lng - 1);
	}
	return false;
}

protected function findVal($set, $key) {
	$arr = VEC::get($this->dat, $set); if (! $arr) return "???";
	$val = $arr[$key]; if (! STR::begins($val, "siehe ")) return $val;
	$fnd = STR::after($val, "siehe");
	return VEC::get($arr, $fnd, $key);
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
protected function getLup($set) {
	if (! $set) return "lup";
	return "lup_$set";
}
protected function embrace($lup, $key) { // eliminates the risk of double
	return "<$lup>$key</$lup>";
}

protected function insLFs($txt, $sep) {
	if ($sep == NV) return $txt;
	$txt = STR::trim($txt, $sep);
	$txt = STR::replace($txt, $sep, "<br>");
	return $txt;
}
protected function insHRef($val) {
	$rep = '<a href="http$1://$2"><img src="LOC_ICO/buttons/web.gif" /></a>';
	return PRG::replace("$val\n", "http(s?)://(.*?)[\n]", $rep);
}

// ***********************************************************
// dummy methods for derived classes
// ***********************************************************
protected function chkVal($txt, $val) {
 // dummy for derived classes
	return $txt;
}

protected function setInfo($set, $key, $val) {
 // dummy for derived classes
 // meant to allow for additional tpl vars
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
