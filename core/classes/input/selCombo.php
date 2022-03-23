<?php
/* ***********************************************************
// INFO
// ***********************************************************
Designed to handle combo box type input items.

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("input/selCombo.php");
# see selector.php
*/

incCls("input/selInput.php");
incCls("input/combo.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class selCombo extends selInput {
	protected $vals = array();

function __construct($pid) {
	parent::__construct($pid);
    $this->read("design/templates/input/selCombo.tpl");
}

// ***********************************************************
// handling items
// ***********************************************************
public function setChoice($options) {
	$this->vals = $options;
}

protected function setValue($value = NV) {
	$val = $this->findKey($value);
	$val = $this->getCurrent($val);
	$xxx = $this->set("curVal", $val);
}
private function findKey($key) {
	return VEC::find($this->vals, $key, $key);
}

protected function chkArray($vls) { // ensure assoc array
	if (! is_array($vls)) return array($vls => $vls);
	if ($vls != array_values($vls)) return $vls;

	$out = array();
	foreach ($vls as $key => $val) {
		$key = $val; if (is_numeric($key)) $key = " $val ";
		$out[$key] = $val; // maintain numeric keys
	}
	return $out;
}

private function valUnknown($val) {
	if ($val === false) return "FALSE";
	if (! $val) return "NOT SET";
	return "[ $val ]";
}

// ***********************************************************
// overruled methods
// ***********************************************************
public function getKey() {
	$val = $this->get("curVal");
	return $this->findKey($val);
}

protected function getType() {
	if (CUR_DEST == "csv") return "csv";

	$arr = $this->vals;
	if (count($arr) < 1) return "ron";
	if (count($arr) < 2) return "ron"; // lok ?

	$rgt = $this->get("perms", "x");
	if ($rgt == "w") return $this->get("sec");
	if ($rgt == "r") return "ron";
	return "noxs";
}

// ***********************************************************
// output
// ***********************************************************
public function td() {
	$typ = $this->getType();

	if ($typ == "cmb") return $this->getCombo();
	if ($typ == "opt") return $this->getRadio();
	if ($typ == "rng") return $this->getRange();
	if ($typ == "ron") { reset($this->vals);
		$this->set("key", key($this->vals));
		$this->set("curVal", current($this->vals));
	}
	return $this->gc("input.$typ");
}

private function getCombo() {
	$nam = $this->get("fname"); $sel = $this->get("curVal");

	$cmb = new combo($nam);
	$cmb->merge($this->vls);
	$cmb->setData($this->vals, $sel);
	return $cmb->gc();
}

private function getRadio() {
	$nam = $this->get("fname"); $out = "";
	$sel = $this->get("curVal");

	foreach ($this->vals as $key => $val) {
		$this->set("key", $key);
		$this->set("caption", $val);
		$this->set("checked", ($key == $sel) ? "CHECKED" : "");

		$out.= $this->gc("input.opt");
	}
	return $out;
}

private function getRange() {
	$nam = $this->get("fname");
	$sel = $this->get("curVal");

	$min = $this->set("min", current($this->vals));
	$max = $this->set("max", end($this->vals));
	return $this->gc("input.rng");
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
