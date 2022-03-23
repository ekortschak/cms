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
    $this->read("design/templates/input/selMulti.tpl");
}

// ***********************************************************
// overruled methodds
// ***********************************************************
public function setMChoice($options, $selected) {
	$this->vals = $options;
	$this->sels = $selected;
}

public function init($type, $qid, $vls, $lang) {
	$cap = STR::between($qid, "[", "]"); if (! $cap) $cap = $qid;
	$cap = DIC::get($cap, $lang);

	$this->setTitle($cap);
	$this->setFname($qid);
	$this->set("sec", STR::left($type)); // refers to template section
}

// ***********************************************************
// output
// ***********************************************************
public function th() {
	return $this->get("title");
}
public function gc($dummy = false) {
	$vls = $this->sels; $opt = "";

    foreach ($this->vals as $key => $val) {
		$sel = VEC::get($vls, $key);
        $sel = ($sel) ? "CHECKED": "";

        $this->set("key", $key);
        $this->set("checked", $sel);
        $this->set("curVal", $val);

        $opt.= $this->getSection("input.mul");
    }
	$xxx = $this->set("items", $opt);
    return $this->getSection();
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
