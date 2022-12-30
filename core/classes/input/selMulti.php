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
	$sel = OID::get($this->oid, $this->uid, $sel);

	if (! is_array($sel)) $sel = array($sel);

	$this->vals = $options;
	$this->sels = $sel;
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
