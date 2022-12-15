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

	$this->setChoice("YES / NO");
}

// ***********************************************************
// handling items
// ***********************************************************
public function setValue($value = false) {
	$val = (bool) $value;
	$val = $this->getValue($value);
	$chk = ($val) ? "CHECKED" : "";

	parent::set("checked", $chk);
	parent::set("curVal", $val);
}

public function setChoice($info = "YES / NO") {
	parent::set("choice", $info);
}

// ***********************************************************
public function getValue($default = NV) {
	$out = parent::getValue($default); if (CUR_DEST == "screen") return $out;
	return ($out) ? BOOL_YES : BOOL_NO;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
