<?php

/* ***********************************************************
// INFO
// ***********************************************************
used to inject explanatory text (dropdown boxes) into pages

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("input/lookup.php");

$lup = new lookup();
$lup->read("lookup/xy.ini");
$lup->insert($text);

*/

incCls("search/lookupAss.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class lookup extends tpl {
	protected $dat = array();  // words to find in a given text
	protected $prp = array();  // props defining how to display occurrences

	protected $tpl = "lookup"; // default template section
	protected $col = "green";  // default color
	protected $sep = ";";      // default string separator

	protected $len = 2;        // max. length of conjugated forms of lookup keys (i.e. length of possible endings)

function __construct() {
	parent::__construct();

	if (CUR_LANG == "de") $this->len = 3;

	switch (VMODE) {
		case "xfer": $this->tpl = "xsite"; break;
	}
	$this->load("other/lookup.tpl");
	$this->readRef();
}

// ***********************************************************
// read ini files
// ***********************************************************
public function readRef() {
	$arr = FSO::files("lookup", "*.ini"); if (! $arr) return;

	foreach ($arr as $fil => $nam) {
		$this->readIni($fil);
	}
}

private function readIni($fil) {
	$ini = new ini($fil);
	$arr = $ini->getValues("data"); if (! $arr) return;
 	$prp = $ini->getValues("props");

 	$arr = VEC::sort($arr, "krsort"); // longest first
	$set = FSO::name($fil);

	$this->prp[$set] = $prp;
	$this->dat[$set] = $arr;
}

// ***********************************************************
// handling properties
// ***********************************************************
protected function getProp($set, $prop, $default) {
	$prp = VEC::get($this->prp, $set); if (! $prp) return $default;
	return VEC::get($prp, $prop, $default);
}

protected function getMask($set) {
	return $this->getProp($set, "tplsec", $this->tpl);
}

public function setTpl($tpl) {
	if (! $this->isSec($tpl)) return;
	$this->tpl = $tpl;
}

// ***********************************************************
// handling lookup strings
// ***********************************************************
public function insert($txt) {
	$txt = $this->inject($txt); // mark items

	foreach ($this->dat as $set => $lst) { // work through all sources
		$sep = $this->getProp($set, "token",  $this->sep);
		$col = $this->getProp($set, "color",  $this->col);
		$sec = $this->getMask($set);

		$xxx = $this->set("color", $col);

		$arr = $this->find($txt, $set); // find previously marked items
		$lup = $this->getLup($set); // get marker: e.g. lup_glossar

		foreach ($arr as $itm) {
			$key = $this->findKey($set, $itm); if (! $key) continue;
			$val = $this->findVal($set, $key); if (! $val) continue;
			$xxx = $this->chkInfo($set, $itm, $key, $val, $sep);

			$fnd = $this->embrace($lup, $itm); // e.g. <lup_glossar>xyz</lup_glossar>
			$rep = $this->getSection($sec);
			$txt = STR::replace($txt, $fnd, $rep);
		}
	}
	return $txt;
}

// ***********************************************************
// prepare and set tpl vars
// ***********************************************************
protected function chkInfo($set, $itm, $key, $val, $sep) {
	$fnc = "do_$set";
	$val = $this->insLFs($val, $sep);
	$val = $this->insHRef($val);

	$this->set("caption", $itm);
	$this->set("key",  $key);
	$this->set("info", $val);

	if (method_exists($this, $fnc)) {
		$this->$fnc($set, $key, $val);
		return;
	}
}

// ***********************************************************
// remove lookup tags
// ***********************************************************
public function clear($txt) {
	foreach ($this->dat as $set => $lst) {
		$lup = $this->getLup($set);
		$txt = STR::replace($txt, "<$lup>", "");
		$txt = STR::replace($txt, "</$lup>", "");
	}
	return $txt;
}

// ***********************************************************
// preparing text for quicker response times
// ***********************************************************
public function inject($txt) {
	$eng = new lookupAss();

	foreach ($this->prp as $set => $prp) {
		$lup = $this->getLup($set); if (STR::contains($txt, "<$lup>")) continue;

		foreach ($this->dat[$set] as $key => $val) {
			if (! $key) continue;
			if (! STR::contains($txt, $key)) continue;

			$rep = $this->embrace($lup, $key);

			$txt = $this->chkVal($txt, $val);
			$txt = $eng->replace($txt, $key, $rep);
		}
	}
	return $txt;
}

protected function chkVal($txt, $val) {
// placeholder for derived classes
	return $txt;
}

// ***********************************************************
// retrieving keys
// ***********************************************************
protected function find($txt, $set = false) {
	$lup = $this->getLup($set);
	return STR::find($txt, "<$lup>", "</$lup>");
}

// ***********************************************************
protected function findKey($set, $key) {
	$arr = VEC::get($this->dat, $set); if (! $arr) return false;
	$lng = strlen($key) - 1;

	for ($i = 0; $i < $this->len; $i++) {
		$val = VEC::get($arr, $key); if ($val) return $key;
		$key = substr($key, 0, $lng--);
	}
	return false;
}

// ***********************************************************
protected function findVal($set, $key) {
	$arr = VEC::get($this->dat, $set); if (! $arr) return false;
	$val = VEC::get($arr, $key);

	$see = "siehe "; if (! STR::begins($val, $see)) return $val;

	$fnd = STR::between($val, $see, ";");
	return VEC::get($arr, $fnd, false);
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
protected function insLFs($txt, $sep) {
	if ($sep === NV) return $txt;

	$txt = PRG::replace($txt, "$sep\s($sep+)", $sep);
	$txt = STR::trim($txt, $sep);
	$txt = STR::replace($txt, $sep, "<br>");
	return $txt;
}

// ***********************************************************
protected function insHRef($txt) {
	if (STR::contains($txt, "<a ")) return $txt;

	$rep = '<a href="http$1://$2"><img src="LOC_ICO/buttons/web.gif" /></a>';
	$out = PRG::replace("$txt ", "http(s?)://(.*?)([ ,;\n]+)", $rep);
	return trim($out);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
