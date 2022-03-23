<?php

/* ***********************************************************
// INFO
// ***********************************************************
used to inject refboxes (explanatory text) into pages

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("input/explain.php");

$lup = new explain();
$lup->read("lookup/xy.ini");
$lup->insert($text);

*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class explain extends objects {
	protected $dat = array(); // words to find in a given text
	protected $prp = array(); // props defining how to display occurrences
	protected $tpl;

	protected $len = 2;       // max. length of conjugated forms of lookup keys (i.e. length of possible endings)
	protected $sec = "lookup";

function __construct() {
	$this->tpl = new tpl();
	$this->tpl->read("design/templates/other/lookup.tpl");

	if (CUR_LANG == "de") $this->len = 3;
}

public function read($fil) {
	if (! is_file($fil)) return;

	$ini = new ini($fil);
	$sec = $ini->get("props.ref", "ref");
	$arr = $ini->getValues($sec); if (! $arr) return;
	$prp = $ini->getValues("props");
	krsort($arr);

	$set = basename($fil);
	$set = STR::before($set, ".");

	$this->prp[$set] = $prp;
	$this->dat[$set] = $arr;
}

// ***********************************************************
// handling template
// ***********************************************************
protected function getSec($set, $sec) {
	if ($sec) return $sec;
	$prp = VEC::get($this->prp, $set); if (! $prp) return $this->sec;
	$out = VEC::get($prp, "tpl");      if (! $out) return $this->sec;
	return $out;
}

protected function setProp($key, $val) {
	$this->tpl->set($key, $val);
}

// ***********************************************************
// handling lookup strings
// ***********************************************************
public function insert($txt, $sec = false) {
	$txt = $this->prepare($txt);

	foreach ($this->dat as $set => $lst) {
		$sec = $this->getSec($set, $sec);
		$arr = $this->find($txt, $set);

		foreach ($arr as $key => $rep) {
			$val = $this->findVal($set, $key);

			if (! $val) continue;
			$val = $this->insLFs($val);

			$xxx = $this->setProp("caption", $key);
			$xxx = $this->setProp("info", $val);
			$txt = $this->replace($txt, $set, $key, $sec);
		}
	}
	return $txt;
}

protected function replace($txt, $set, $key, $sec) {
	$fnd = $this->embrace($set, $key);
	$rep = $this->tpl->getSection($sec);
	return str_ireplace($fnd, $rep, $txt);
}

// ***********************************************************
// preparing text for quicker response times
// ***********************************************************
public function prepare($txt) {
	foreach ($this->dat as $set => $lst) {

		foreach ($lst as $key => $val) {
			if (! STR::contains($txt, $key)) continue;
			$rep = $this->embrace($set, $key);
			$txt = PRG::replaceWords($txt, $key, $rep);
		}
	}
	return $txt;
}

protected function insLFs($txt) { // dummy for derived classes
	return $txt;
}

protected function embrace($set, $key) { // eliminates the risk of double
	return "<lup_$set>$key</lup_$set>";
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
protected function findVal($set, $key) {
	for ($i = 0; $i < $this->len; $i++) {
		$val = VEC::get($this->dat[$set], $key); if ($val) return $val;
		$lng = strlen($key);
		$key = substr($key, 0, $lng - 1);
	}
	return false;
}

protected function find($txt, $set) {
	return STR::find($txt, "<lup_$set>", "</lup_$set>");
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
