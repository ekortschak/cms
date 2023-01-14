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
	$arr = FSO::files("lookup/*.ini"); if (! $arr) return false;

	foreach ($arr as $fil => $nam) {
		$this->read($fil);
	}
	return true;
}

public function read($fil) {
	if (! is_file($fil)) return;

	$ini = new ini($fil);
	$arr = $ini->getValues("data*"); if (! $arr) return;
 	$prp = $ini->getValues("props");
	krsort($arr);

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
		$sep = $this->getProp($set, "sep", NV);
		$sec = $this->getProp($set, "tplsec", $this->sec);
		$col = $this->getProp($set, "color",  $this->col);
		$xxx = $this->setProp("color", $col);

		$arr = $this->find($txt, $set);
		$lup = $this->getLup($set);

		foreach ($arr as $key) {
			$ref = $this->findKey($set, $key); if (! $ref) continue;
			$val = $this->findVal($set, $ref);
			$val = $this->insLFs($val, $sep);

			$val = PRG::replace("$val\n", "http(s?)://(.*?)[\n]", '<a href="http$1://$2"><img src="ICONS/buttons/web.gif" /></a>');
			$inf = "<b>$ref</b><br>$val";

			$xxx = $this->setProp("caption", $key);
			$xxx = $this->setProp("info", $inf);
			$xxx = $this->setInfo($set, $ref, $val);

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
	}
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

			$rep = $this->embrace($lup, $key);
			$fnd = PRG::quote($key);
			$txt = PRG::replaceWords($txt, $fnd, $rep);
		}
		$txt = $this->cleanTags($txt, $lup);
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
	$key = STR::after($val, "siehe");
	return VEC::get($arr, $key, "???");
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

// ***********************************************************
// dummy methods for derived classes
// ***********************************************************
protected function setInfo($set, $key, $val) {
	// dummy for derived classes
	// meant to allow for additional tpl vars
}
protected function insLFs($txt, $sep) {
	if ($sep == NV) return $txt;
	$txt = STR::replace($txt, $sep, "<br>");
	return $txt;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
