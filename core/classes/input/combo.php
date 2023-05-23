<?php
/* ***********************************************************
// INFO
// ***********************************************************
Used to create combo boxes in selectors.

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("input/combo.php");

$cmb = new combo($name);
$cmb->setData($values, $selected)
$cmb->show();
*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class combo extends tpl {
	protected $dat;
	private $sel = NV;

function __construct($name) {
	parent::__construct();
    $this->load("input/selCombo.tpl");
	$this->set("fname", $name);
	$this->register();
}

// ***********************************************************
// methods
// ***********************************************************
public function setData($dat, $selected = NV) {
	$this->dat = $this->chkVal($dat);
	$this->sel = $this->chkSel($dat, $selected);
	return $this->sel;
}

// ***********************************************************
// output
// ***********************************************************
public function gc($dummy = false) {
	$opt = "";

    foreach ($this->dat as $key => $val) {
        $sel = ""; if ($key == $this->sel) $sel = "selected";

        $this->set("key", $key);
        $this->set("selected", $sel);
        $this->set("option", $val);

        $opt.= $this->getSection("item");
    }
	if (! $opt) return $this->getSection("empty");

	$xxx = $this->set("options", $opt);
    return $this->getSection();
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function chkSel($vls, $sel) {
	return VEC::find($vls, $sel, $sel);
}
private function chkVal($val) {
	if (! is_array($val)) return array($val, $val);
	if ($val != array_values($val)) return $val;
	$out = array();

	foreach ($val as $itm) {
		if (is_array($itm)) $itm = "Array";
		$out[$itm] = $itm;
	}
	return $out;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
