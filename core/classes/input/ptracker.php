<?php
/* ***********************************************************
// INFO
// ***********************************************************
serves as temporary storage for selectors and confirms
* watches their post vars
* determines if any action is required prior to display

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("input/ptracker.php");

$ptk = new ptracker();
$ptk->watch("cnf.act", true);

if ($ptk->get("sel_name")) {
	// do whatever needs to be done
}

*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class ptracker {
	private $oid = NV;
	private $lock = true;

function __construct() {
	$this->oid = OID::register($oid, $sfx);

	foreach ($_POST as $key => $val) {
		OID::set($this->oid, $key, $val);
	}
}

// ***********************************************************
// methods
// ***********************************************************
public function watch($key = "cnf.act", $val = true) {
	$chk = OID::get($this->oid, $key, NV); if ($chk === NV) return;
	$this->lock = ($chk != $val);
	return (! $this->lock);
}

public function get($key, $default = false) {
	if ($this->lock) return false;

	$out = OID::get($this->oid, $key, NV); if ($out === NV) return false;
	$xxx = OID::forget($this->oid);

	if ($out !== NV) return $out;
	return $default;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
