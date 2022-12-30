<?php
/* ***********************************************************
// INFO
// ***********************************************************
watches unique IDs

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("other/uids.php");

$itm = new uids();
$itm->getID($key, $value);

*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class uids {
	private $sep = "§";
	private $dat = array();

function __construct() {}

// ***********************************************************
public function getUID($key, $value = "") {
	$key = STR::before($key, $this->sep); // eliminate trailing numbers
	$key = STR::before($key, ":"); // downward compatibility
	$val = trim($value);

	$itm = VEC::get($this->dat, $key);
	$cnt = VEC::get($itm, "cnt") + 1;

	$this->dat[$key] = array(
		"cnt" => $cnt,
		"val" => $val
	);
	return $this->get($key);
}

private function get($key) {
	if (! isset($this->dat[$key])) return false;

	$cnt = $this->dat[$key]["cnt"]; if ($cnt < 2) return $key;
	$sep = $this->sep;

	return "$key$sep$cnt";
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
