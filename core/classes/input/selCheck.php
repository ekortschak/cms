<?php
/* ***********************************************************
// INFO
// ***********************************************************
Designed to handle checkboxes

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("input/selCheck.php");
# see selector.php
*/

incCls("input/selInput.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class selCheck extends selInput {

function __construct($pid) {
	parent::__construct($pid);
}

// ***********************************************************
// handling items
// ***********************************************************
public function setValue($value = false) {
	$val = (bool) $value;
	$val = $this->getCurrent($value);
	$chk = ($val) ? "CHECKED" : "";

	$this->set("checked", $chk);
	$this->setChoice("YES / NO");

	parent::set("curVal", $val);
}

public function setChoice($info = "YES / NO") {
	$this->set("choice", $info);
}

// ***********************************************************
public function getValue() {
	$out = $this->get("curVal"); if (CUR_DEST == "screen")
	return $out;
	return ($out) ? "&check;" : "&cross;";
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
