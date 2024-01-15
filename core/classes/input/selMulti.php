<?php
/* ***********************************************************
// INFO
// ***********************************************************
Designed to handle multi select input items.

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("input/selMulti.php");
# see selector.php
*/

incCls("input/selInput.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class selMulti extends selCombo {
	private $sels = array();

function __construct($pid) {
	parent::__construct($pid);
    $this->load("input/selMulti.tpl");
}

// ***********************************************************
// overruled methodds
// ***********************************************************
public function setChoice($options) {
	$sel = $this->get("value");
	$sel = parent::get("curVal", $sel);
	$sel = $this->recall($this->uid, $sel);

	$this->vals = $options;
	$this->sels = $this->getChoice($options, $sel);
	return $this->sels;
}

private function getChoice($arr, $sel) {
	if (is_array($sel)) return $sel;

	foreach ($arr as $key => $val) {
		$arr[$key] = (bool) $sel;
	}
	return $arr;
}

// ***********************************************************
public function getValue($default = NV) { // get session value
	$out = $this->vals;

	foreach ($this->sels as $key => $val) {
		if (! $val) unset($out[$key]);
	}
	return $out;
}

// ***********************************************************
// output
// ***********************************************************
public function getTool() {
	$key = $this->get("fname");
	$typ = $this->getType();
	$opt = "";

	if (count($this->vals) < 2) $this->clearSec("info.hint");
	if (count($this->vals) < 1) $this->setSec("input.head", NV);

    foreach ($this->vals as $key => $val) {
		$sel = VEC::get($this->sels, $key);
        $sel = ($sel) ? "CHECKED": "";

        $this->set("key", $key);
        $this->set("checked", $sel);
        $this->set("curVal", $val);

        $opt.= $this->getSection("input.$typ");
    }
	$xxx = $this->set("items", $opt);
    return $this->getSection();
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
