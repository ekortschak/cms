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
    $this->load("input/selCombo.tpl");
}

// ***********************************************************
// handling items
// ***********************************************************
public function setChoice($options) {
	switch (count($options)) {
		case 0: $this->setType("txt"); break;
		case 1: $this->setType("ron"); break;
	}
	$this->vals = $options;
}

protected function setValue($value = NV) {
	$val = $this->findKey($value);
	$val = $this->getValue($val);
	$xxx = $this->set("curVal", $val);
}
private function findKey($key) {
	return VEC::find($this->vals, $key, $key);
}

// ***********************************************************
// overruled methods
// ***********************************************************
public function getKey() {
	$val = $this->get("curVal");
	return $this->findKey($val);
}

// ***********************************************************
// output
// ***********************************************************
public function getTool() {
	$typ = $this->getType();

	if ($typ == "cmb") return $this->getCombo();
	if ($typ == "opt") return $this->getRadio();
	if ($typ == "rng") return $this->getRange();
	if ($typ == "ron") { reset($this->vals);
		$this->set("key", key($this->vals));
		$this->set("curVal", current($this->vals));
	}
	return $this->getSection("input.$typ");
}

// ***********************************************************
private function getCombo() {
	$cur = $this->get("curVal"); $out = $itm = "";

	foreach ($this->vals as $key => $val) {
        $sel = ""; if ($key == $cur) $sel = "selected";

		$this->set("key", $key);
		$this->set("selected", $sel);
        $this->set("option", $val);

		$itm.= $this->getSection("item");
	}
	$this->set("options", $itm);
	return $this->getSection();
}

// ***********************************************************
private function getRadio() {
	$cur = $this->get("curVal"); $out = "";

	foreach ($this->vals as $key => $val) {
		$this->set("key", $key);
		$this->set("caption", $val);
		$this->set("checked", ($key == $cur) ? "CHECKED" : "");

		$out.= $this->getSection("input.opt");
	}
	return $out;
}

// ***********************************************************
private function getRange() {
	$min = $this->set("min", current($this->vals));
	$max = $this->set("max", end($this->vals));
	return $this->gc("input.rng");
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
