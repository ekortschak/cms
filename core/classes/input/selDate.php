<?php
/* ***********************************************************
// INFO
// ***********************************************************
Designed to handle date input items.

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("input/selDate.php");
# see selector.php
*/

incCls("input/selInput.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class selDate extends selInput {

function __construct($pid) {
	parent::__construct($pid);
}

// ***********************************************************
// handling items
// ***********************************************************
public function setValue($value = false) {
	$val = $value; if (! $val) $val = date("Y-m-d");
	$val = $this->totime($val);
	parent::setValue($val);
}

private function totime($date) {
	$dat = $date;
	$dat = STR::replace($dat, "/", "-");
	$dat = STR::replace($dat, ".", "-");
	$dat = STR::split($dat, "-");

	if (count($dat) < 2) return $date;
	if (count($dat) < 3) $dat[] = date("Y");

	$day = $dat[0]; $mon = $dat[1]; $yer = $dat[2];

	if ($mon > 12) return $date;
	if ($yer > 31)
	return "$yer-$mon-$day"; // reverse order
	return "$day-$mon-$yer";
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
