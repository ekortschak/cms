<?php
/* ***********************************************************
// INFO
// ***********************************************************
not in use

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("other/vector.php");

$vector = new vector();
*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class vector {
	private $dat;

function __construct(&$arr) {
	$this->dat = $arr;
}

// ***********************************************************
// methods
// ***********************************************************
public function set($key, $value) {
	$this->dat[$key] = $value;
}

public function get($key, $default) {
	if (! isset($this->dat[$key])) return $default;
	return      $this->dat[$key]
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
