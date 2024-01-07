<?php
/* ***********************************************************
// INFO
// ***********************************************************
use this class to count items

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("other/counter.php");

$obj = new counter();
$obj->count($key);
*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class counter {
	private $dat = array();

function __construct() {}

// ***********************************************************
// methods
// ***********************************************************
public function count($key, $inc = 1) {
	$this->chkKey($key);
	$this->dat[$key] += $inc;
}

public function set($key, $value) {
	$this->dat[$key] = $value;
}

public function get($key) {
	return VEC::get($this->dat, $key);
}

public function getData($key = false) {
	return VEC::sort($this->dat, "arsort");
}

public function show() {
	DBG::vector($this->dat);
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function chkKey($key) {
	if (isset($this->dat[$key])) return;
	$this->dat[$key] = 0;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
